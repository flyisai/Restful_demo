@education
Feature: Doctor's administrators should be able to add education records to doctor's profiles (TODO LOGIN)

  Scenario: Displaying education record in the doctor's profile
    Given I go to "http://127.0.0.1/doctor/1"
    Then I should see "Medical School"

#assuming logged in user and correct user
  Scenario: Creating education record with correct information
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "myemail@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    And I go to "/login"
    And I fill in "username" with "myemail@example.com"
    And I fill in "password" with "password"
    And I press "Login"

    And I go to "http://127.0.0.1/doctorprofile"
    And I fill in "name" with "Master Yoda"
    And I fill in "speciality" with "Force Master"
    And I fill in "street_address" with "Galaxy far away"
    And I select "Java" from "province_id"
    And I select "Bali" from "city_id"
    And I fill in "postcode" with "123456"
    And I fill in "country" with "Tattoie"
    And I fill in "phone" with "123456789"
    And I fill in "email" with "yoda@example.com"
    And I fill in "license_number" with "123456789"
    And I press "post"




    And  I go to "http://127.0.0.1/doctors"
    And I follow "Master Yoda"
    When I follow "Add"
    And I fill in "graduation_year" with "1999"
    And I fill in "organization_name" with "Big Hospital"
    And I select "Medical School" from "type"
    And I press "Add"
    Then the response status code should be 200
    And I should see "Big Hospital"
    And I should see "1999"

  Scenario: Creating education record with incorrect information
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "myemail@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    And I go to "/login"
    And I fill in "username" with "myemail@example.com"
    And I fill in "password" with "password"
    And I press "Login"

    And I go to "http://127.0.0.1/doctorprofile"
    And I fill in "name" with "Master Yoda"
    And I fill in "speciality" with "Force Master"
    And I fill in "street_address" with "Galaxy far away"
    And I select "Java" from "province_id"
    And I select "Bali" from "city_id"
    And I fill in "postcode" with "123456"
    And I fill in "country" with "Tattoie"
    And I fill in "phone" with "123456789"
    And I fill in "email" with "yoda@example.com"
    And I fill in "license_number" with "123456789"
    And I press "post"

    And  I go to "http://127.0.0.1/doctors"
    And I follow "Master Yoda"
    And I follow "Add"
    And I press "Add"
    Then the response status code should be 200
    Then I should see the element with css ".error"

  Scenario: Editing education record with correct information
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "myemail@example.com"
    And I fill in "password" with "password"
    And I fill in "password_again" with "password"
    And I press "Register"
    And  I go to "/login"
    And I fill in "username" with "myemail@example.com"
    And I fill in "password" with "password"
    And I press "Login"

    And I go to "http://127.0.0.1/doctorprofile"
    And I fill in "name" with "Master Yoda"
    And I fill in "speciality" with "Force Master"
    And I fill in "street_address" with "Galaxy far away"
    And I select "Java" from "province_id"
    And I select "Bali" from "city_id"
    And I fill in "postcode" with "123456"
    And I fill in "country" with "Tattoie"
    And I fill in "phone" with "123456789"
    And I fill in "email" with "yoda@example.com"
    And I fill in "license_number" with "123456789"
    And I press "post"

    And  I go to "http://127.0.0.1"
    And I follow "Master Yoda"
    When I follow "Add"
    And I fill in "graduation_year" with "1999"
    And I fill in "organization_name" with "Big Hospital"
    And I select "Medical School" from "type"
    And I press "Add"
    And I go to "http://127.0.0.1"
    And I follow "Master Yoda"
    And I follow "Edit"
    And I fill in "organization_name" with "Even Bigger Hospital"
    And I press "Update"
    Then I should see "Even Bigger Hospital"

#tests pending for not logged in user

  Scenario: Not logged in user is attempting to manipulate records
    Given I go to "http://127.0.0.1/doctor/1"
    Then I should not see "Add"

