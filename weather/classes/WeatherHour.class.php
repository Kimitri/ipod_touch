<?php
/**
 * @file
 * HTML output for a single hourly weather forecast.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

class WeatherHour {
  const HTML_TEMPLATE = '<li style="background-image: linear-gradient(to top, #90c7e8 0%%, #90c7e8 %s, white %s, white 100%%)">
          <span class="time">%d</span>
          <span class="icon">%s</span>
          <span class="temp">%s</span>
        </li>';

  public static $tz_offset = 0;

  public static function render($hour) {
    $prop = '1h';
    $rain = (!empty($hour->rain)) ? $hour->rain->{$prop} : 0;
    $rain_clamp = $rain / 10 * 100;

    $params = array(
      self::HTML_TEMPLATE,
      $rain_clamp . '%',
      $rain_clamp . '%',
      date('H', $hour->dt + self::$tz_offset),
      Icon::render($hour->weather[0]->icon),
      Temperature::render($hour->temp)
    );

    return call_user_func_array('sprintf', $params);
  }
}