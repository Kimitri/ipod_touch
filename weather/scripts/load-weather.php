#!/usr/local/bin/php
<?php

require(__DIR__ . '/../classes/OpenWeatherMap.class.php');
require(__DIR__ . '/../classes/InkplateOutput.class.php');
require(__DIR__ . '/../classes/ImageContext.class.php');
require(__DIR__ . '/../classes/ImageChunkInterface.class.php');
require(__DIR__ . '/../classes/CurrentImageChunk.class.php');
require(__DIR__ . '/../classes/TodayImageChunk.class.php');
require(__DIR__ . '/../classes/ForecastImageChunk.class.php');

OpenWeatherMap::load('fi');
InkplateOutput::writeImages(OpenWeatherMap::load('en'));
