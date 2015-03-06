Feature: It should be possible to find the weather from the API
  In order to allow users to stay ahead of the weather
  As a user interested in the weather
  We need to return data when a postcode is searched for

  Scenario: When a user searches for a postcode, they are returned the current weather for that postcode
    When I request the weather from the API for postcode "N19 5BW"
    Then the response status code should be 200
    And the response should contain the weather "clear"

  Scenario: None existent postcodes do not return weather
    When I request the weather from the API for postcode "_________"
    Then the response status code should be 404