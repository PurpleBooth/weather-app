<?php

namespace PurpleBooth\WeatherApp\Test\Unit\Service;

use Mockery as m;
use PurpleBooth\WeatherApp\Service\StaticWeatherService;

/**
 * Test the StaticWeatherService
 *
 * @package PurpleBooth\WeatherApp\Test\Unit\Service
 */
class StaticWeatherServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StaticWeatherService
     */
    private $instance;

    public function testTheWeatherServiceGetsWeather()
    {
        $response = $this->instance->getWeather("N19 5BW");
        $this->assertInternalType('string', $response);
        $this->assertEquals('clear', $response);
    }

    public function testGeoCodeFailureCausesNull()
    {
        $response = $this->instance->getWeather("Anything else");
        $this->assertInternalType('null', $response);
        $this->assertEquals(null, $response);
    }

    protected function setUp()
    {
        $this->instance = new StaticWeatherService();
    }
}
