@web @authentication
Feature: Connected users should access the homepage
    As a connected user
    I can access to the homepage

    Scenario: As a connected user I can see the homepage
      Given I am authenticated as user
      When  I am on the homepage
      Then  the response status code should be 200
      And   I should see text matching "Activity Feed"

    Scenario: As a connected admin I can see the homepage
        Given I am authenticated as admin
        When  I am on the homepage
        Then  the response status code should be 200
        And   I should see text matching "Activity Feed"
