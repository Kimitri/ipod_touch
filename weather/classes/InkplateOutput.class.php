<?php

class InkplateOutput {
  const CACHE_PATH = '/var/www/cache/weather';
  const CACHE_TTL = 900;

  public static function out($data) {
    $png_location = self::CACHE_PATH . '/image.png';
    $bmp_location = self::CACHE_PATH . '/image.bmp';

    if (!file_exists($bmp_location) || filemtime($bmp_location) < time() - self::CACHE_TTL) {
      $context = new ImageContext($data);
      $context
        ->addImageChunk('CurrentImageChunk', 50, 40)
        ->addImageChunk('TodayImageChunk', 460, 70)
        ->addImageChunk('ForecastImageChunk', 50, 320);

      $image = $context->image();

      imagepng($image, $png_location);
      imagedestroy($image);

      self::convertImage($png_location, $bmp_location);
    }

    header('Content-Type: image/bmp');
    header('Content-Length: ' . filesize($bmp_location));
    readfile($bmp_location);
  }

  protected static function convertImage($source, $dest) {
    $command = 'convert ' . $source . ' -background white -flatten -depth 2 -dither FloydSteinberg ' . $dest;
    exec($command);
  }
}