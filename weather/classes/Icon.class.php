<?php
/**
 * @file
 * HTML output for a weather icon.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

class Icon {
  const HTML_TEMPLATE = '<img src="icons/%s@2x.png" />';

  /**
   * Renders the output.
   * 
   * @param  string  $id
   * Open Wearher Map icon ID.
   * 
   * @return string
   * HTML output.
   */
  public static function render($id) {
    return sprintf(self::HTML_TEMPLATE, $id);
  }
}