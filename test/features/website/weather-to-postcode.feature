Feature: It should be possible to find the weather from the website
  In order to allow users to stay ahead of the weather
  As a user interested in the weather
  We need to return data when a postcode is searched for

  Scenario: When a user searches for a postcode, they are returned the current weather for that postcode
    When I request the weather from the website for postcode "N19 5BW"
    Then the website should contain the weather "clear"

  Scenario: When a user searches for a postcode, they are returned the current weather for that postcode
    When I request the weather from the website for postcode "ZZZZZZ"
    Then the website should contain the weather "Unknown"
