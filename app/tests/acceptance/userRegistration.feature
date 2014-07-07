Feature: Registering users
  In order to access restricted pages of the site
  As a user
  I need to be able to register

  Scenario: When password or email are not present
    Given I go to "http://127.0.0.1/register"
    When I press "Register"
    Then the response status code should be 200
    And I should see "The email field is required"
    And I should see "The password field is required"
    And I should see "The password again field is required"

  Scenario: When email is wrong format
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    Then the response status code should be 200
    And I should be on "http://127.0.0.1/register"
    And I should see "The email must be a valid email address."

  Scenario: Passwords do not match
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "badpass"
    And I press "Register"
    Then the response status code should be 200    
    And I should see "password must match"

  Scenario: email must be unique
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    Then I go to "http://127.0.0.1/register"  
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    Then the response status code should be 200    
    And I should see "The email has already been taken"

  Scenario: User can register using email and password
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    Then the response status code should be 200
    And I should see a record with "email" that is "joe@example.com" in the "users" table in the database
    And I should be on "http://127.0.0.1/myprofile"
