<?php
/**
 * @file
 * HTML output for a weather icon.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

class Icon {
  const HTML_TEMPLATE = '<img src="http://openweathermap.org/img/wn/%s@2x.png" />';

  public static function render($id) {
    return sprintf(self::HTML_TEMPLATE, $id);
  }
}