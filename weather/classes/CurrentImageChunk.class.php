<?php

class CurrentImageChunk implements ImageChunkInterface {
  protected $context;
  protected $icon;
  protected $temp;
  protected $desc;

  public function __construct(ImageContext $context) {
    $this->context = $context;
    $data = $this->context->data();
    $icon_file = ImageContext::ICON_PATH . '/' . $data->current->weather[0]->icon . '@2x.png';
    $this->icon = imagecreatefrompng($icon_file);
    $this->temp = number_format($data->current->temp, 0);
    $this->desc = strtoupper($data->current->weather[0]->description);
  }

  public function renderAt($x, $y) {
    $image = $this->context->image();
    $colors = $this->context->colors();
    $black = $colors['black'];
    
    imagecopy($image, $this->icon, $x, $y, 0, 0, 100, 100);
    imagettftext($image, 40, 0, $x + 120, $y + 70, $black, ImageContext::FONT_REGULAR, $this->temp);
    imagettftext($image, 20, 0, $x + 20, $x + 130, $black, ImageContext::FONT_REGULAR, $this->desc);
  }
}