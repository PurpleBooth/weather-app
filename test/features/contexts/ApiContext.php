<?php

namespace PurpleBooth\WeatherApp\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Defines application features from the specific context.
 */
class ApiContext implements Context, SnippetAcceptingContext
{

    /**
     * @var \Behat\MinkExtension\Context\MinkContext
     */
    private $minkContext;

    /**
     * Set the mink context
     *
     * @param BeforeScenarioScope $scope The event
     *
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        /** @var \Behat\MinkExtension\Context\MinkContext minkContext */
        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');
    }

    /**
     * @When I request the weather from the API for postcode :postcode
     *
     * @param string $postcode The postcode
     */
    public function iRequestTheWeatherFromTheApiForPostcode($postcode)
    {
        $this->minkContext->visit('/api/v1/' . urlencode($postcode));
    }


    /**
     * @Then the response should contain the weather :weather
     *
     * @param string $weather The expected weather
     *
     * @throws \Exception
     */
    public function theResponseShouldContainTheWeather2($weather)
    {
        if (!$this->minkContext->getSession()->getPage()->hasContent(json_encode(['description' => $weather]))) {
            throw new \Exception("No weather");
        }
    }
}
