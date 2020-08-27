<?php

class TodayImageChunk implements ImageChunkInterface {
  protected $context;
  protected $icon;
  protected $temp;
  protected $desc;

  public function __construct(ImageContext $context) {
    $this->context = $context;
    $data = $this->context->data();
    $icon_file = ImageContext::ICON_PATH . '/' . $data->daily[0]->weather[0]->icon . '@2x.png';
    $this->icon = imagecreatefrompng($icon_file);
    $this->temp = number_format($data->daily[0]->temp->min, 0) . '...' . number_format($data->daily[0]->temp->max, 0);
    $this->desc = strtoupper($data->daily[0]->weather[0]->description);
  }

  public function renderAt($x, $y) {
    $image = $this->context->image();
    $colors = $this->context->colors();
    $black = $colors['black'];
    $font = ImageContext::FONT_REGULAR;

    imagettftext($image, 20, 0, $x, $y, $black, $font, 'TODAY');
    imagecopy($image, $this->icon, $x, $y + 10, 0, 0, 100, 100);
    imagettftext($image, 20, 0, $x + 100, $y + 60, $black, $font, $this->temp);
    imagettftext($image, 16, 0, $x + 100, $y + 90, $black, $font, $this->desc);
  }
}