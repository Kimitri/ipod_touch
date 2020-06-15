<?php
/**
 * @file
 * HTML output for a single daily weather forecast.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

require_once('Icon.class.php');
require_once('Temperature.class.php');

class WeatherDay {
  const HTML_TEMPLATE = '<li style="background-image: linear-gradient(to top, #90c7e8 0%%, #90c7e8 %s%, white %s%, white 100%%)">
          <div class="date">
            <div class="weekday">
              %s
            </div>
            %s
          </div>
          <div class="forecast">
            <div class="desc">
              %s
            </div>
            <div>
              <span class="icon">%s</span>
              <span class="temp">%s</span>  
            </div>
          </div>
        </li>';

  public static $tz_offset = 0;
  protected static $localized_days = array(
    'su',
    'ma',
    'ti',
    'ke',
    'to',
    'pe',
    'la'
  );

  public static function render($day) {
    $rain = (!empty($day->rain)) ? $day->rain : 0;
    $rain_clamp = $rain / 50 * 100;
    $timestamp = $day->dt + self::$tz_offset;

    $params = array(
      self::HTML_TEMPLATE,
      $rain_clamp,
      $rain_clamp,
      self::$localized_days[date('w', $timestamp)],
      date('d.m.', $timestamp),
      $day->weather[0]->description,
      Icon::render($day->weather[0]->icon),
      Temperature::render($day->temp->day)
    );

    return call_user_func_array('sprintf', $params);
  }
}