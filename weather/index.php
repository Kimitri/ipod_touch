<?php
require_once('classes/OpenWeatherMap.class.php');
require_once('classes/WeatherNow.class.php');
require_once('classes/WeatherToday.class.php');
require_once('classes/WeatherDaily.class.php');


$css_sources = array(
  'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700;&display=swap',
  'css/styles.css'
);

$preload = array_map(function($url) {
    return sprintf('<%s>; rel=preload', $url);
  },
  $css_sources
);

header('Content-Type: text/html; charset=utf-8');
header('Link: ' . implode(', ', $preload));
ob_flush();

$data = OpenWeatherMap::load();
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sää</title>
</head>
<body>
  <?php echo WeatherNow::render($data); ?>
  <?php echo WeatherToday::render($data); ?>
  <?php echo WeatherDaily::render($data); ?>
  
  <script type="text/javascript">
    const css_sources = <?php echo json_encode($css_sources); ?>;
    const head = document.querySelectorAll('head')[0];
    css_sources.forEach(src => {
      const link = document.createElement('link');
      link.setAttribute('href', src);
      link.setAttribute('rel', 'stylesheet');
      head.appendChild(link);
    });
  </script>
</body>
</html>
