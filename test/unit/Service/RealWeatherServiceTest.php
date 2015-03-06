<?php

namespace PurpleBooth\WeatherApp\Test\Unit\Service;

use Geocoder\Exception\NoResultException;
use Mockery as m;
use PurpleBooth\WeatherApp\Service\RealWeatherService;

/**
 * Test the RealWeatherService
 *
 * @package PurpleBooth\WeatherApp\Test\Unit\Service
 */
class RealWeatherServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RealWeatherService
     */
    private $instance;

    private $geocodeService;

    private $forecastService;

    private $eventDispatcher;

    public function testTheWeatherServiceGetsWeather()
    {
        $this->geocodeService->shouldReceive('getGeocodedData')
            ->with("Some Postcode")
            ->andReturn([['latitude' => 12, 'longitude' => 32]]);

        $this->eventDispatcher->shouldReceive('dispatch')
            ->with('weather.service', m::type('PurpleBooth\WeatherApp\Event\ApiCall'))
            ->twice();

        $expectedResponse                     = new \stdClass();
        $expectedResponse->currently          = new \stdClass();
        $expectedResponse->currently->summary = "cloudy";

        $this->forecastService->shouldReceive('get')
            ->with(12, 32)
            ->andReturn($expectedResponse);

        $response = $this->instance->getWeather("Some Postcode");
        $this->assertInternalType('string', $response);
        $this->assertEquals('cloudy', $response);
    }

    public function testGeoCodeFailureCausesNull()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->with('weather.service', m::type('PurpleBooth\WeatherApp\Event\ApiCall'));

        $this->geocodeService->shouldReceive('getGeocodedData')
            ->with("Some Postcode")
            ->andThrow(new NoResultException());

        $response = $this->instance->getWeather("Some Postcode");
        $this->assertEquals(null, $response);
    }

    protected function setUp()
    {

        $this->eventDispatcher = m::mock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->geocodeService  = m::mock('Geocoder\Provider\ProviderInterface');
        $this->forecastService = m::mock('Forecast\Forecast');

        $this->instance = new RealWeatherService(
            $this->geocodeService,
            $this->forecastService,
            $this->eventDispatcher
        );
    }
}
