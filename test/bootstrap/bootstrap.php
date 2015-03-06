<?php

$autoloader = require __DIR__ . '/../../vendor/autoload.php';
$autoloader->add('PurpleBooth\\WeatherApp\\Test\\Unit', __DIR__ . "/unit");
$autoloader->add('PurpleBooth\\WeatherApp\\Test\\Context', __DIR__ . "/features/contexts");

$loader = new \Mockery\Loader;
$loader->register();
