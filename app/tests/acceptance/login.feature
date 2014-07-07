Feature: Logging users in
  In order to access restricted pages of the site
  As a user
  I need to login

  Scenario: When password and email are not present
    Given I go to "http://127.0.0.1/login"
    When I press "Login"
    Then the response status code should be 200
    And I should see "The username field is required"
    And I should see "The password field is required"

  Scenario: When password and username do not match
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"    
    Then I go to "http://127.0.0.1/login"
    When I fill in "username" with "joe@example.com"
    And I fill in "password" with "badpass"    
    When I press "Login"
    Then the response status code should be 200
    And I should see "Incorrect username or password"

  Scenario: Login success
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"    
    Then I go to "http://127.0.0.1/login"
    When I fill in "username" with "joe@example.com"
    And I fill in "password" with "password"    
    When I press "Login"
    Then the response status code should be 200
    Then I should be on "http://127.0.0.1/doctors"    

  Scenario: When forgotten password link is clicked
    Given I go to "http://127.0.0.1/login"  
    When I follow "Forgot your password?"
    Then I should be on "http://127.0.0.1/resetpassword"