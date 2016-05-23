@web
Feature: No access to anonymous users
    As an anonymous
    I cannot access any page on the application

    Scenario: As an anonymous user I can't see the homepage and I am redirected to login
        Given I am an anonymous user
        When  I go to the homepage
        Then  I should be redirected to "/login/"
