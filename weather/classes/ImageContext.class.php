<?php

class ImageContext {
  const ICON_PATH = '../icons_gray';

  const FONT_BOLD = '../fonts/Lato-Bold.ttf';
  const FONT_REGULAR = '../fonts/Lato-Regular.ttf';

  const IMAGE_WIDTH = 796;
  const IMAGE_HEIGHT = 598;

  protected $image;
  protected $data;
  protected $colors;


  public function __construct(stdClass $data) {
    $this->data = $data;
    $this->image = imagecreatetruecolor(self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
    $this->colors['white'] = imagecolorallocate($this->image, 255, 255, 255);
    $this->colors['black'] = imagecolorallocate($this->image, 0, 0, 0);
    imagefill($this->image, 0, 0, $this->colors['white']);
  }

  public function addImageChunk($chunkClass, $offset_x, $offset_y) {
    $chunk = new $chunkClass($this);
    $chunk->renderAt($offset_x, $offset_y);
    return $this;
  }

  public function image() {
    return $this->image;
  }

  public function colors() {
    return $this->colors;
  }

  public function data() {
    return $this->data;
  }
}