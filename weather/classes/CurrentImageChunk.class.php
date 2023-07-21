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
    $icon_file = fopen(ImageContext::ICON_PATH . '/' . $data->current->weather[0]->icon . '@2x.png', 'r');
    $this->icon = new Imagick();
    $this->icon->readImageFile($icon_file);
    $this->icon->scaleImage(100, 100);
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
    
    $draw = new ImagickDraw();
    $draw->setFont(ImageContext::FONT_REGULAR);
    $draw->setFontSize(40);
    $draw->setFillColor($black);
    
    $draw->annotation($x + 120, $y + 70, $this->temp);

    $draw->setFontSize(20);
    $draw->annotation($x + 20, $y + 160, $this->desc);

    $image->drawImage($draw);
    $image->compositeImage($this->icon, Imagick::COMPOSITE_DEFAULT, $x, $y);
  }
}
