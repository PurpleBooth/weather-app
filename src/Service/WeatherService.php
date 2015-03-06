<?php

namespace PurpleBooth\WeatherApp\Service;

/**
 * Interface for implementations of a service that gets weather at a location
 *
 * @package PurpleBooth\WeatherApp\Service
 */
interface WeatherService
{

    /**
     * Get the current weather from a string
     *
     * @param string $location The location (e.g. a postcode)
     *
     * @return null|string Null on failure
     */
    public function getWeather($location);
}
