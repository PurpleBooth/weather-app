<?php

use Forecast\Forecast;
use Geocoder\HttpAdapter\CurlHttpAdapter;
use Geocoder\Provider\GoogleMapsProvider;
use PurpleBooth\WeatherApp\Controller\PostcodeApiController;
use PurpleBooth\WeatherApp\Controller\PostcodeWebsiteController;
use PurpleBooth\WeatherApp\Service\RealWeatherService;
use PurpleBooth\WeatherApp\Service\StaticWeatherService;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);

$appEnv = getenv("APP_ENV");

$app['debug'] = true;

$app['eventDispatcher'] = $app->share(function() use ($app) {
    return new EventDispatcher();
});

$app['service.forecast'] = $app->share(function() use ($app) {
    return new Forecast(getenv('FORECAST_IO_KEY'));
});

$app['service.geocode'] = $app->share(function() use ($app) {
    $geocoder = new GoogleMapsProvider(
        new CurlHttpAdapter()
    );

    return $geocoder;
});

$app['service.weather'] = $app->share(function() use ($app) {
    if (getenv("APP_ENV") === 'test') {
        $weather = new StaticWeatherService();
    } else {
        $weather = new RealWeatherService(
            $app['service.geocode'],
            $app['service.forecast'],
            $app['eventDispatcher']
        );
    }

    return $weather;
});

$app['postcode.api.controller'] = $app->share(function() use ($app) {
    return new PostcodeApiController($app['service.weather']);
});


$app['postcode.website.controller'] = $app->share(function() use ($app) {
    return new PostcodeWebsiteController($app['twig']);
});

$app->get('/api/v1/{location}', "postcode.api.controller:getAction");
$app->get('/', "postcode.website.controller:indexAction");


$app->run();
