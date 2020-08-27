<?php

class ForecastImageChunk implements ImageChunkInterface {
  protected $context;

  public function __construct(ImageContext $context) {
    $this->context = $context;
  }

  public function renderAt($x, $y) {
    $image = $this->context->image();
    $data = $this->context->data();
    $colors = $this->context->colors();
    $black = $colors['black'];
    $font = ImageContext::FONT_REGULAR;
    $width = 275;

    $days = array_slice($data->daily, 1, 3);

    foreach ($days as $index => $day) {
      $x_pos = $x + $index * $width;
      $timestamp = $day->dt + $data->timezone_offset;
      $icon_file = ImageContext::ICON_PATH . '/' . $day->weather[0]->icon . '@2x.png';
      $icon_image = imagecreatefrompng($icon_file);
      
      imagettftext($image, 20, 0, $x_pos + 35, $y, $black, $font, date('D', $timestamp));
      imagecopy($image, $icon_image, $x_pos + 10, $y + 30, 0, 0, 100, 100);
      imagettftext($image, 20, 0, $x_pos + 45, $y + 160, $black, $font, number_format($day->temp->day, 0));
      imagettftext($image, 12, 0, $x_pos, $y + 200, $black, $font, strtoupper($day->weather[0]->description));
    }
  }
}