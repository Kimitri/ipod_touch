<?php
/**
 * @file
 * A simple Open Weather Map One Call API client.
 *
 * @author Kimmo Tapala <kimitri@gmail.com>
 */
class OpenWeatherMap {
  const API_KEY_PATH = '/var/www_storage/openweathermap_api_key.txt';
  const API_URL_STR = 'https://api.openweathermap.org/data/2.5/onecall?lat=%F&lon=%F&exclude=%s&units=%s&lang=%s&appid=%s';
  const API_UNITS = 'metric';
  const API_LANG = 'fi';

  const COORDINATE_PATH = '/var/www_storage/home_coordinates.txt';

  const CACHE_PATH = '/var/www/cache/weather';
  const CACHE_TTL = 3600;

  protected static $exclude = array(
    'minutely'
  );

  /**
   * Loads weather data.
   *
   * @return object
   * Deserialized weather data.
   */
  public static function load() {
    $api_key = trim(file_get_contents(self::API_KEY_PATH));
    $location = explode(',', trim(file_get_contents(self::COORDINATE_PATH)));
    $url = sprintf(self::API_URL_STR, $location[0], $location[1], implode(',', self::$exclude), self::API_UNITS, self::API_LANG, $api_key);

    $contents = self::readFromCache($url);

    if (is_null($contents)) {
      $contents = file_get_contents($url);
      self::writeToCache($url, $contents);
    }
    
    return json_decode($contents);
  }

  /**
   * Reads data from cache.
   * 
   * @param  string $url
   * API call URL.
   * 
   * @return string
   * Cached weather data or null if the data doesn't exist or is stale.
   */
  protected static function readFromCache($url) {
    $file = self::cachePath($url);
    if (!file_exists($file) || filemtime($file) < time() - self::CACHE_TTL) {
      return null;
    }

    return file_get_contents($file);
  }

  /**
   * Writes data to cache.
   * 
   * @param  string $url
   * API call URL.
   * 
   * @param  string $contents
   * Contents to cache.
   */
  protected static function writeToCache($url, $contents) {
    $file = self::cachePath($url);
    file_put_contents($file, $contents);
  }

  /**
   * Returns the cache path corresponding to the object name.
   * 
   * @param  string $name
   * Cache object name.
   * 
   * @return string
   * Cache file location.
   */
  protected static function cachePath($name) {
    return self::CACHE_PATH . '/' . md5($name);
  }
}