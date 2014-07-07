Feature: Very basic test if Behat is working with Vagrant and our project
  In order to know if that shit is running
  As a user
  I need to be able to see if I can go to page and click on a link

  Scenario: Visiting doctor's profile
    Given I go to "http://127.0.0.1"
    When I follow "Maggie Seaver"
    Then I should see "maggie@mail.com"