<?php

namespace PurpleBooth\WeatherApp\Controller;

use PurpleBooth\WeatherApp\Service\WeatherService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for weather API
 *
 * @package PurpleBooth\WeatherApp\Controller
 */
class PostcodeApiController
{

    /**
     * @var WeatherService
     */
    private $weatherService;

    /**
     * The constructor
     *
     * @param WeatherService $weatherService The weather service
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Get a Json representation of the weather
     *
     * @param string $location The location
     *
     * @return JsonResponse
     */
    public function getAction($location)
    {
        $weatherServiceResponse = $this->weatherService->getWeather(str_replace("+", " ", $location));
        $jsonResponse           = new JsonResponse(
            ['description' => $weatherServiceResponse],
            JsonResponse::HTTP_OK
        );

        if ($weatherServiceResponse === null) {
            $jsonResponse->setStatusCode(JsonResponse::HTTP_NOT_FOUND);
        }

        return $jsonResponse;
    }
}
