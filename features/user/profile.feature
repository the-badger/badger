@web
Feature: User can view its own profile
    As a user
    I need to be able to view my profile

    Scenario: As a connected user I can view my profile
        Given I am authenticated as "user"
        When  I follow "My Profile"
        Then  I should be on route "userprofile"
        And   I should see text matching "No unlocked badge"
