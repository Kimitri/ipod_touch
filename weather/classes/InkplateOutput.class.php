<?php
/**
 * @file
 * Grayscale BMP output for the Inkplate 6 e-paper display.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class InkplateOutput {
  const CACHE_PATH = '/var/www/cache/weather';
  const CACHE_TTL = 900;

  /**
   * Renders and outputs the BMP binary.
   * 
   * @param  object $data
   * Data returned by the Open Weather Map API.
   */
  public static function out($data) {
    $png_location = self::CACHE_PATH . '/image.png';
    $bmp_location = self::CACHE_PATH . '/image.bmp';

    if (!file_exists($bmp_location) || filemtime($bmp_location) < time() - self::CACHE_TTL) {
      $context = new ImageContext($data);
      $context
        ->addImageChunk('CurrentImageChunk', 70, 40)
        ->addImageChunk('TodayImageChunk', 460, 90)
        ->addImageChunk('ForecastImageChunk', 40, 320);

      $image = $context->image();

      imagepng($image, $png_location);
      imagedestroy($image);

      self::convertImage($png_location, $bmp_location);
    }

    header('Content-Type: image/bmp');
    header('Content-Length: ' . filesize($bmp_location));
    readfile($bmp_location);
  }

  /**
   * Converts the PHP-generated PNG into BMP.
   *
   * As the GD library is unable to output BMP images, the image is first
   * rendered as PNG and then converted into BMP using Imagemagick. The PHP
   * installation does not have the Imagemagick library installed, so the
   * conversion is done by executing a shell command.
   * 
   * @param  string $source
   * Source image path.
   * 
   * @param  string $dest
   * Destination image path.
   */
  protected static function convertImage($source, $dest) {
    $command = 'convert ' . $source . ' -background white -flatten -depth 2 -dither FloydSteinberg ' . $dest;
    exec($command);
  }
}