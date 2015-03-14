<?php

namespace PurpleBooth\WeatherApp\Test\Unit\Controller;

use Mockery as m;
use PurpleBooth\WeatherApp\Controller\PostcodeApiController;

/**
 * Test the PostcodeApiController
 *
 * @package PurpleBooth\WeatherApp\Test\Unit\Controller
 */
class PostcodeApiControllerTest extends \PHPUnit_Framework_TestCase
{

    private $weatherService;

    /**
     * @var PostcodeApiController
     */
    private $instance;

    public function testHasGetActionThatReturnsResponse()
    {
        $this->weatherService->shouldReceive('getWeather')
            ->with("Some Postcode")
            ->andReturn("cloudy");

        $response = $this->instance->getAction("Some Postcode");
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals('{"description":"cloudy"}', $response->getContent());
    }

    public function testDoesGetAction404OnFalseResponse()
    {
        $this->weatherService->shouldReceive('getWeather')
            ->with("None Existent Postcode")
            ->andReturn(null);

        $response = $this->instance->getAction("None Existent Postcode");
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    protected function setUp()
    {
        $this->weatherService = m::mock('PurpleBooth\WeatherApp\Service\WeatherService');
        $this->instance       = new PostcodeApiController($this->weatherService);
    }
}
