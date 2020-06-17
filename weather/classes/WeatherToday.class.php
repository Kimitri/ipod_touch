<?php
/**
 * @file
 * HTML output for today's weather forecast.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */

require_once('Icon.class.php');
require_once('Temperature.class.php');
require_once('WeatherHour.class.php');

class WeatherToday {
  const HTML_TEMPLATE = '<section class="today">
    <header>
      <h2>Tänään</h2>
    </header>
    <div class="hi-lo">
      <span class="icon">%s</span>
      <span class="nobreak">
        <span class="lo">%s</span>
        <span>&hellip;</span>
        <span class="hi">%s</span>
      </span>
    </div>
    <ul class="hourly">
      %s
    </ul>
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
    WeatherHour::$tz_offset = $data->timezone_offset;
    $params = array(
      self::HTML_TEMPLATE,
      Icon::render($data->daily[0]->weather[0]->icon),
      Temperature::render($data->daily[0]->temp->min),
      Temperature::render($data->daily[0]->temp->max),
      implode('', array_map(array('WeatherHour','render'), $data->hourly))
    );

    return call_user_func_array('sprintf', $params);
  }
}