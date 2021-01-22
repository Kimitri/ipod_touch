<?php
/**
 * @file
 * Image chunk displaying the current weather.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class CurrentImageChunk implements ImageChunkInterface {
  protected $context;
  protected $icon;
  protected $temp;
  protected $desc;

  /**
   * Constructor.
   * 
   * @param ImageContext $context
   * Image context.
   */
  public function __construct(ImageContext $context) {
    $this->context = $context;
    $data = $this->context->data();
    $icon_file = ImageContext::ICON_PATH . '/' . $data->current->weather[0]->icon . '@2x.png';
    $this->icon = imagecreatefrompng($icon_file);
    $this->temp = number_format($data->current->temp, 0);
    $this->desc = strtoupper($data->current->weather[0]->description);
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
    $colors = $this->context->colors();
    $black = $colors['black'];
    
    imagecopy($image, $this->icon, $x, $y, 0, 0, 100, 100);
    imagettftext($image, 40, 0, $x + 120, $y + 70, $black, ImageContext::FONT_REGULAR, $this->temp);
    imagettftext($image, 20, 0, $x + 20, $y + 160, $black, ImageContext::FONT_REGULAR, $this->desc);
  }
}