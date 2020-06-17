<?php
/**
 * @file
 * HTML output for current weather.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

require_once('Icon.class.php');
require_once('Temperature.class.php');

class WeatherNow {
  const HTML_TEMPLATE = '<section class="now">
    <header>
      <span class="date">%s</span>
      <span class="time">%s</span>
    </header>
    <div class="icon">
      %s
    </div>
    <div class="temp">
      %s
    </div>
    <div class="feels">
      Tuntuu kuin %s
    </div>
    <div class="desc">
      %s
    </div>
  </section>';

  /**
   * Renders the output.
   * 
   * @param  object  $data
   * Data from the Open Weather Map API response.
   * 
   * @return string
   * HTML output.
   */
  public static function render($data) {
    $timestamp = $data->current->dt + $data->timezone_offset;
    $params = array(
      self::HTML_TEMPLATE,
      date('d.m.', $timestamp),
      date('H.i', $timestamp),
      Icon::render($data->current->weather[0]->icon),
      Temperature::render($data->current->temp),
      Temperature::render($data->current->feels_like),
      $data->current->weather[0]->description
    );

    return call_user_func_array('sprintf', $params);
  }
}