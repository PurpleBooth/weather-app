<?php

namespace PurpleBooth\WeatherApp\Test\Unit\Event;

use Mockery as m;
use PurpleBooth\WeatherApp\Event\ApiCall;

/**
 * Test the ApiCall
 *
 * @package PurpleBooth\WeatherApp\Test\Unit\Event
 */
class ApiCallTest extends \PHPUnit_Framework_TestCase
{

    public function testTheWeatherServiceGetsWeather()
    {
        $instance = new ApiCall('call', 'params', 'result');
        $this->assertEquals('call', $instance->getCall());
        $this->assertEquals('params', $instance->getParameters());
        $this->assertEquals('result', $instance->getResult());
    }
}
