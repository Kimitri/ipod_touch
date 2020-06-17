<?php
/**
 * @file
 * HTML output for a temperature value.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class Temperature {
  const HTML_TEMPLATE = '%d°C';

  /**
   * Renders the output.
   * 
   * @param  float  $temp
   * Temperature in Celsius degrees.
   * 
   * @return string
   * HTML output.
   */
  public static function render($temp) {
    return sprintf(self::HTML_TEMPLATE, number_format($temp, 0));
  }
}