Feature: Searching doctors using search fields on the home page

  Scenario: Searching Doctors in /doctors path by name
    Given I go to "http://127.0.0.1/doctors"
    When I fill in "name" with "Carol Seaver"
    And I press "search"
    Then the response status code should be 200
    And I should see "Maggie Seaver"

  Scenario: Searching Doctors in /doctors path by speciality
    Given I go to "http://127.0.0.1/doctors"
    When I select "internist" from "speciality"
    And I press "search"
    Then I should not see "Carol Seaver"

  Scenario: Searching Doctors from /doctors path by unique name
    Given I go to "http://127.0.0.1/doctors"
    When I fill in "name" with "Carol"
    And I press "search"
    Then the response status code should be 200
    And I should not see "Maggie"

  Scenario: Searching Doctors from root path by full name
    Given I go to "http://127.0.0.1"
    When I fill in "name" with "Carol Seaver"
    And I press "search"
    Then the response status code should be 200
    And I should see "Maggie Seaver"


  Scenario: Searching Doctors in from root path by speciality
    Given I go to "http://127.0.0.1"
    When I select "internist" from "speciality"
    And I press "search"
    Then I should not see "Carol"
