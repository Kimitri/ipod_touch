<?php
/**
 * @file
 * HTML output for a list of daily weather forecasts.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

require_once('WeatherDay.class.php');

class WeatherDaily {
  const HTML_TEMPLATE = '<section class="daily">
    <header>
      <h2>Ennuste</h2>
    </header>
    <ul class="daily">
     %s
    </ul>
  </section>';

  public static function render($data) {
    WeatherDay::$tz_offset = $data->timezone_offset;
    $params = array(
      self::HTML_TEMPLATE,
      implode('', array_map(array('WeatherDay', 'render'), $data->daily))
    );

    return call_user_func_array('sprintf', $params);
  }
}