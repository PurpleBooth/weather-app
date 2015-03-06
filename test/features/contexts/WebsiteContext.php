<?php

namespace PurpleBooth\WeatherApp\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Defines application features from the specific context.
 */
class WebsiteContext implements Context, SnippetAcceptingContext
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

        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');
    }

    /**
     * @When I request the weather from the website for postcode :location
     *
     * @param string $location
     */
    public function iRequestTheWeatherFromTheWebsiteForPostcode($location)
    {
        $this->minkContext->visit('/');
        // Wait for angular js to finish loading
        $this->minkContext->getSession()->wait(5000, 'typeof window.angular == "object"');
        $this->minkContext->fillField('location', $location);
    }

    /**
     * @Then the website should contain the weather :weather
     *
     * @param string $weather The expected weather
     */
    public function theWebsiteShouldContainTheWeather($weather)
    {
        // Wait for the text to be on the page
        $this->minkContext->getSession()->wait(
            5000,
            'document.getElementsByClassName("weather")[0].innerHTML = ' . json_encode($weather, true) . ';'
        );
        $this->minkContext->assertPageContainsText($weather);
    }
}
