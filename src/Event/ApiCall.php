<?php

namespace PurpleBooth\WeatherApp\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * An API call has been made
 *
 * @package PurpleBooth\WeatherApp\Event
 */
class ApiCall extends Event
{
    /**
     * @var string
     */
    private $call;
    /**
     * @var mixed
     */
    private $parameters;
    /**
     * @var mixed
     */
    private $result;

    /**
     * The constructor
     *
     * @param string $call       A key to identify the call being made
     * @param mixed  $parameters The parameters passed to the call
     * @param mixed  $result     The result of the call
     */
    public function __construct($call, $parameters, $result)
    {
        $this->call       = $call;
        $this->parameters = $parameters;
        $this->result     = $result;
    }

    /**
     * Get the call being made
     *
     * @return string
     */
    public function getCall()
    {
        return $this->call;
    }

    /**
     * Get the parameters
     *
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get the results of the call
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
