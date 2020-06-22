<?php
require_once('classes/OpenWeatherMap.class.php');
require_once('classes/WeatherNow.class.php');
require_once('classes/WeatherToday.class.php');
require_once('classes/WeatherDaily.class.php');


$css_sources = array(
  'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap',
  'css/styles.css'
);

$preload = array_map(function($url) {
    return sprintf('<%s>; rel=preload', $url);
  },
  $css_sources
);

header('Content-Type: text/html; charset=utf-8');
header('Link: ' . implode(', ', $preload));
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sää</title>
  <?php foreach($css_sources as $css_source): ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $css_source; ?>">
  <?php endforeach; ?>
</head>
<body>
  <section id="loading">
    <h2>Ladataan...</h2>
    <span></span>
  </section>
  <?php
    flush();
    ob_flush();

    $data = OpenWeatherMap::load();

    echo WeatherNow::render($data);
    echo WeatherToday::render($data);
    echo WeatherDaily::render($data);
  ?>
  <style type="text/css" media="screen">
    #loading {
      display: none;
    }
  </style>
</body>
</html>
