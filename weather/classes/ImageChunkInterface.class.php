<?php

interface ImageChunkInterface {
  public function __construct(ImageContext $context);
  public function renderAt($offset_x, $offset_y);
}