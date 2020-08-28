<?php
/**
 * @file
 * An image context for a composite image consisting of image chunks.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class ImageContext {
  const ICON_PATH = '/var/www/weather/icons_gray';

  const FONT_BOLD = '/var/www/weather/fonts/Lato-Bold.ttf';
  const FONT_REGULAR = '/var/www/weather/fonts/Lato-Regular.ttf';

  const IMAGE_WIDTH = 796;
  const IMAGE_HEIGHT = 598;

  protected $image;
  protected $data;
  protected $colors;

  /**
   * Constructor.
   * 
   * @param stdClass $data
   * Data returned by the Open Weather Map API.
   */
  public function __construct(stdClass $data) {
    $this->data = $data;
    $this->image = imagecreatetruecolor(self::IMAGE_WIDTH, self::IMAGE_HEIGHT);
    $this->colors['white'] = imagecolorallocate($this->image, 255, 255, 255);
    $this->colors['black'] = imagecolorallocate($this->image, 0, 0, 0);
    imagefill($this->image, 0, 0, $this->colors['white']);
  }

  /**
   * Adds a new image chunk to the image.
   * 
   * @param string $chunkClass
   * Image chunk class name. (i.e. 'CurrentImageChunk')
   * 
   * @param int    $offset_x
   * Chunk position X coordinate.
   * 
   * @param int    $offset_y
   * Chunk position Y coordinate.
   *
   * @return ImageContext
   * Returns this instance to allow chaining.
   */
  public function addImageChunk($chunkClass, $offset_x, $offset_y) {
    $chunk = new $chunkClass($this);
    $chunk->renderAt($offset_x, $offset_y);
    return $this;
  }

  /**
   * Returns the image resource identifier.
   * 
   * @return resource
   * Image resource identifier.
   */
  public function image() {
    return $this->image;
  }

  /**
   * Returns the color palette array.
   * 
   * @return array
   * An associated array of allocated colors.
   */
  public function colors() {
    return $this->colors;
  }

  /**
   * Returns the data object passed to the constructor.
   * 
   * @return object
   * Data returned by the Open Weather Map API.
   */
  public function data() {
    return $this->data;
  }
}