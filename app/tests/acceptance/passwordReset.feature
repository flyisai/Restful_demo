Feature: Reset Password
  If I forget my password
  As a user
  I need to be able to reset it

  Scenario: when email is not filled in
    Given I go to "http://127.0.0.1/resetpassword"
    And press "Send reset email"
    Then the response status code should be 200
    And I should see "The email field is required"    

  Scenario: email is not in db
    Given I go to "http://127.0.0.1/resetpassword"
    And I fill in "email" with "crazyd00d@example.com"
    And press "Send reset email"
    Then the response status code should be 200
    And I should see "The selected email is invalid."    

  Scenario: password reset email is sent
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"   
    Given I go to "http://127.0.0.1/resetpassword"
    And I fill in "email" with "joe@example.com"
    And press "Send reset email"
    Then the response status code should be 200
    And I should be on "http://127.0.0.1/resetpasswordemailsent"
    And the last log entry should contain "Pretending to mail message"

  Scenario: password reset link works
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"   
    Given I go to "http://127.0.0.1/resetpassword"
    And I fill in "email" with "joe@example.com"
    And press "Send reset email"
    Then the response status code should be 200
    And I open the password reset link for "joe@example.com"
    Then I should be on the password reset page for "joe@example.com"

  Scenario: password and password again not present on password reset page
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"   
    Given I go to "http://127.0.0.1/resetpassword"
    And I fill in "email" with "joe@example.com"
    And press "Send reset email"
    Then the response status code should be 200
    And I open the password reset link for "joe@example.com"
    Then I should be on the password reset page for "joe@example.com"
    Given I press "Save new password"
    Then the response status code should be 200
    And I should see "The password field is required"
    And I should see "The password again field is required"

  Scenario: password and password again do not match
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"   
    Given I go to "http://127.0.0.1/resetpassword"
    And I fill in "email" with "joe@example.com"
    And press "Send reset email"
    Then the response status code should be 200
    And I open the password reset link for "joe@example.com"
    Then I should be on the password reset page for "joe@example.com"
    Given I press "Save new password"
    Then the response status code should be 200
    When I fill in "password" with "foo"
    And I fill in "password_again" with "bar"
    And I press "Save new password"
    Then I should see "The passwords you entered do not match"

  Scenario: password successfully reset
    Given I go to "http://127.0.0.1/register"
    When I fill in "email" with "joe@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"   
    Given I go to "http://127.0.0.1/resetpassword"
    And I fill in "email" with "joe@example.com"
    And press "Send reset email"
    Then the response status code should be 200
    And I open the password reset link for "joe@example.com"
    Then I should be on the password reset page for "joe@example.com"
    Given I press "Save new password"
    Then the response status code should be 200
    When I fill in "password" with "totallynewpass"
    And I fill in "password_again" with "totallynewpass"
    And I press "Save new password"    
    Then I should be on "http://127.0.0.1:2504/resetpasswordthanks"
    Given I go to "http://127.0.0.1/login"
    When I fill in "username" with "joe@example.com"
    And I fill in "password" with "totallynewpass"    
    When I press "Login"
    Then the response status code should be 200
    Then I should be on "http://127.0.0.1/doctors"    