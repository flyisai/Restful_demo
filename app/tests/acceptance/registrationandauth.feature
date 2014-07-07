Feature: Account Creation
    In order to access restricted parts of the site
    As a use
    I need to register
    Given I go to "http://127.0.0.1:2504/register"
    And fill in email with 'foo@example.com'
    And fill in password with 'password'
    And press