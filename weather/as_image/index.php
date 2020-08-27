<?php
require('../classes/OpenWeatherMap.class.php');
require('../classes/InkplateOutput.class.php');
require('../classes/ImageContext.class.php');
require('../classes/ImageChunkInterface.class.php');
require('../classes/CurrentImageChunk.class.php');
require('../classes/TodayImageChunk.class.php');
require('../classes/ForecastImageChunk.class.php');

InkplateOutput::out(OpenWeatherMap::load('en'));