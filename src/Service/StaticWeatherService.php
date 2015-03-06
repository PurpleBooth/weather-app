<?php

namespace PurpleBooth\WeatherApp\Service;

/**
 * Implementation of the weather service for testing purposes, so we're not hitting our usage limit
 *
 * @package PurpleBooth\WeatherApp\Service
 */
class StaticWeatherService implements WeatherService
{
    /**
     * @var array
     */
    private $data = ['N19 5BW' => 'clear'];

    /**
     * Get the current weather from a string
     *
     * @param string $location The location (e.g. a postcode)
     *
     * @return null|string Null on failure
     */
    public function getWeather($location)
    {
        if (array_key_exists($location, $this->data)) {
            return $this->data[$location];
        }

        return null;
    }
}
