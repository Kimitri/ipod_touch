<?php
require_once('classes/OpenWeatherMap.class.php');
require_once('classes/WeatherNow.class.php');
require_once('classes/WeatherToday.class.php');
require_once('classes/WeatherDaily.class.php');

header('Content-Type: text/html; charset=utf-8');
$data = OpenWeatherMap::load();

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sää</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  <?php echo WeatherNow::render($data); ?>
  <?php echo WeatherToday::render($data); ?>
  <?php echo WeatherDaily::render($data); ?>
</body>
</html>
