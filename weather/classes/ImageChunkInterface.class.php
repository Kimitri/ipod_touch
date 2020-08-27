<?php
/**
 * @file
 * Interface implemented by all image chunks that can be placed inside an
 * image context.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
interface ImageChunkInterface {
  public function __construct(ImageContext $context);
  public function renderAt($offset_x, $offset_y);
}