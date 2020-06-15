<?php

require('../classes/OpenWeatherMap.class.php');

header('Content-Type: application/json; charset=utf-8');

echo json_encode(OpenWeatherMap::load());