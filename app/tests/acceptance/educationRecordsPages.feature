Feature: Doctor's administrators should be able to add education records to doctor's profiles (TODO LOGIN)

  Scenario: Displaying education record in the doctor's profile
    Given I go to "http://127.0.0.1/doctors/1"
    Then I should see "Medical School"

#assuming logged in user
  Scenario: Creating education record with correct information
    Given  I go to "http://127.0.0.1/doctors/1"
    When I follow "Add"
    And I fill in "graduation_year" with "1999"
    And I fill in "organization_name" with "Big Hospital"
    And I select "Medical School" from "type"
    And I press "Add"
    Then the response status code should be 200
    And I should see "Big Hospital"
    And I should see "1999"

  Scenario: Creating education record with incorrect information
    Given  I go to "http://127.0.0.1/doctors/1/education_record/create"
    And I press "Add"
    Then the response status code should be 200
    And I should see "error"

#TODO tests pending for not logged in user
