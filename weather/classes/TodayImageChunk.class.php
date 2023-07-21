<?php
/**
 * @file
 * Image chunk displaying today's weather.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class TodayImageChunk implements ImageChunkInterface {
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
    $day = $data->daily[0];
    $icon_file = ImageContext::ICON_PATH . '/' . $day->weather[0]->icon . '@2x.png';
    $this->icon = new Imagick();
    $this->icon->readImage($icon_file);
    $this->icon->scaleImage(100, 100);
    $this->temp = number_format($day->temp->min, 0) . '...' . number_format($day->temp->max, 0);
    $this->desc = strtoupper($day->weather[0]->description);
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
    $font = ImageContext::FONT_REGULAR;

    $draw = new ImagickDraw();
    $draw->setFont($font);
    $draw->setFontSize(20);
    $draw->setFillColor($black);

    $image->annotateImage($draw, $x, $y, 0, 'TODAY');
    $image->compositeImage($this->icon, Imagick::COMPOSITE_DEFAULT, $x, $y + 10);
    $image->annotateImage($draw, $x + 100, $y + 60, 0, $this->temp);

    $draw->setFontSize(16);
    $image->annotateImage($draw, $x + 100, $y + 90, 0, $this->desc);
  }
}
