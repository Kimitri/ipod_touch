<?php
/**
 * @file
 * Grayscale BMP output for the Inkplate 6 e-paper display.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class InkplateOutput {
  const CACHE_TTL = 900;
  const IMAGE_PNG = '/var/www_storage/cache/weather/image.png';
  const IMAGE_BMP = '/var/www_storage/cache/weather/image.bmp';

  /**
   * Renders and outputs the BMP binary.
   * 
   * @param  object $data
   * Data returned by the Open Weather Map API.
   */
  public static function out($data) {
    if (!file_exists(self::IMAGE_BMP) || filemtime(self::IMAGE_BMP) < time() - self::CACHE_TTL) {
      self::writeImages($data);
    }

    header('Content-Type: image/bmp');
    header('Content-Length: ' . filesize(self::IMAGE_BMP));
    readfile(self::IMAGE_BMP);
  }

  /**
   * Writes images to cache.
   * 
   * @param  object $data
   * Data returned by the Open Weather Map API.
   */
  public static function writeImages($data) {
    $context = new ImageContext($data);
    $context
      ->addImageChunk('CurrentImageChunk', 70, 40)
      ->addImageChunk('TodayImageChunk', 460, 90)
      ->addImageChunk('ForecastImageChunk', 40, 320);

    $image = $context->image();
    $image->setImageFormat('png');
    $image->writeImage(self::IMAGE_PNG);

    self::convertImage(self::IMAGE_PNG, self::IMAGE_BMP);
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
