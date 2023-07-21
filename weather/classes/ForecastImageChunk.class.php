<?php
/**
 * @file
 * Image chunk displaying a three day weather forecast.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class ForecastImageChunk implements ImageChunkInterface {
  protected $context;
  
  /**
   * Constructor.
   * 
   * @param ImageContext $context
   * Image context.
   */
  public function __construct(ImageContext $context) {
    $this->context = $context;
  }

  /**
   * Renders the chunk at a specified position in the image.
   * 
   * @param  int    $x
   * X coordinate of the chunk position.
   * 
   * @param  int    $y
   * Y coordinate of the chunk position.
   */
  public function renderAt($x, $y) {
    $image = $this->context->image();
    $data = $this->context->data();
    $colors = $this->context->colors();
    $black = $colors['black'];
    $font = ImageContext::FONT_REGULAR;
    $width = 233;

    $days = array_slice($data->daily, 1, 3);

    foreach ($days as $index => $day) {
      $x_pos = $x + $index * $width;
      $timestamp = $day->dt + $data->timezone_offset;
      $icon_file = ImageContext::ICON_PATH . '/' . $day->weather[0]->icon . '@2x.png';
      $icon_image = new Imagick();
      $icon_image->readImage($icon_file);
      $icon_image->scaleImage(100, 100);
      
      $this->centerText($width, 20, 0, $x_pos, $y, $black, $font, date('D', $timestamp));
      $this->centerText($width, 20, 0, $x_pos, $y, $black, $font, date('D', $timestamp));
      $image->compositeImage($icon_image, Imagick::COMPOSITE_DEFAULT, $x_pos + 67, $y + 30);
      $this->centerText($width, 20, 0, $x_pos, $y + 160, $black, $font, number_format($day->temp->day, 0));
      $this->centerText($width, 12, 0, $x_pos, $y + 200, $black, $font, strtoupper($day->weather[0]->description));
    }
  }

  /**
   * Renders text horizontally centered in a specified region.
   * 
   * @param  int    $target_width
   * Region width.
   * 
   * @param  int    $text_size
   * Text size.
   * 
   * @param  float  $angle
   * Text angle.
   * 
   * @param  int    $offset_x
   * Region offset X coordinate.
   * 
   * @param  int    $offset_y
   * Region offset Y coordinate.
   * 
   * @param  color  $color
   * Text GD color.
   * 
   * @param  string $font
   * Font file.
   * 
   * @param  string $text
   * Text to render.
   */
  protected function centerText($target_width, $text_size, $angle, $offset_x, $offset_y, $color, $font, $text) {
    $image = $this->context->image();
    $draw = new ImagickDraw();
    $draw->setFont($font);
    $draw->setFontSize($text_size);
    $draw->setFillColor($color);

    $metrics = $image->queryFontMetrics($draw, $text);
    $text_width = $metrics['textWidth'];
    $text_x = round($offset_x + ($target_width - $text_width) / 2);

    $image->annotateImage($draw, $text_x, $offset_y, $angle, $text);
  }
}
