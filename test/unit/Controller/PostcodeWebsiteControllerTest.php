<?php

namespace PurpleBooth\WeatherApp\Test\Unit\Controller;

use Mockery as m;
use PurpleBooth\WeatherApp\Controller\PostcodeWebsiteController;

/**
 * Test the PostcodeWebsiteController
 *
 * @package PurpleBooth\WeatherApp\Test\Unit\Controller
 */
class PostcodeWebsiteControllerTest extends \PHPUnit_Framework_TestCase
{

    private $instance;
    private $twig;

    public function testHasGetActionThatReturnsResponse()
    {
        $this->twig->shouldReceive('render')
            ->with('index.html.twig')
            ->andReturn("some html");

        $response = $this->instance->indexAction();
        $this->assertEquals("some html", $response);
    }

    protected function setUp()
    {
        $this->twig = m::mock('Twig_Environment');
        $this->instance = new PostcodeWebsiteController($this->twig);
    }
}
