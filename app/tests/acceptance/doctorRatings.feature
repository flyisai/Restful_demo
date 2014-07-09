Feature: Doctor Ratings
  In order to know which doctor to go to and evaluate my experience
  As a user
  I need to be able see doctor ratings and rate doctors

  Scenario: I can't rate doctors while not logged in
    When I go to "http://127.0.0.1/doctors/2"
    Then I should not see an "doctor_rating_form" element

  Scenario: Rating a doctor for the first time
    Given I register and login as "zhuangzi@example.com" with password "password"
    When I go to "http://127.0.0.1/doctor/1"
    Then the response status code should be 200
    When I select "1" from "clarity"
    And I select "3" from "listening"
    And I press "doctor_rating_submit"
    Then I should see a "DoctorRating" model with "doctor_id" field equal to "1" that has "clarity, listening" set to "1, 3" respectively

  Scenario: Updating my rating for a doctor
    Given I register and login as "zhuangzi@example.com" with password "password"
    When I go to "http://127.0.0.1/doctor/1"
    Then the response status code should be 200
    When I select "1" from "clarity"
    And I press "doctor_rating_submit"
    And I select "4" from "clarity"
    And I select "3" from "listening"
    And I press "doctor_rating_submit"
    Then I should see a "DoctorRating" model with "doctor_id" field equal to "1" that has "clarity, listening" set to "4, 3" respectively
