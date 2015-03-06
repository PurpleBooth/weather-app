<?php

namespace PurpleBooth\WeatherApp\Service;

use Forecast\Forecast;
use Geocoder\Exception\NoResultException;
use Geocoder\Provider\ProviderInterface;
use PurpleBooth\WeatherApp\Event\ApiCall;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Implementation of the weather service using Google Maps and Forecast.IO
 *
 * @package PurpleBooth\WeatherApp\Service
 */
class RealWeatherService implements WeatherService
{

    /**
     * @var ProviderInterface
     */
    private $geocodeService;
    /**
     * @var Forecast
     */
    private $forecastService;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * The constructor
     *
     * @param ProviderInterface        $geocodeService  The geocode service
     * @param Forecast                 $forecastService The forecast service
     * @param EventDispatcherInterface $eventDispatcher The event dispatcher
     */
    public function __construct(
        ProviderInterface $geocodeService,
        Forecast $forecastService,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->geocodeService  = $geocodeService;
        $this->forecastService = $forecastService;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get a string version of the current weather at a location
     *
     * @param string $location The location (e.g. a postcode)
     *
     * @return null|string Null on failure
     */
    public function getWeather($location)
    {
        try {
            $latLong = $this->geocodeService->getGeocodedData($location);
            $this->eventDispatcher->dispatch('weather.service', new ApiCall('geocode', $location, $latLong));
        } catch (NoResultException $e) {
            $this->eventDispatcher->dispatch('weather.service', new ApiCall('geocode', $location, null));

            return null;
        }

        $firstItemFromArray = array_shift($latLong);

        $weather = $this->forecastService->get(
            $firstItemFromArray['latitude'],
            $firstItemFromArray['longitude']
        );

        $this->eventDispatcher->dispatch('weather.service', new ApiCall('forecast', $location, $weather));

        return $weather->currently->summary;
    }
}
