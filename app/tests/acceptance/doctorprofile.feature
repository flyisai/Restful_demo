@doctorProfile
Feature: login user
  register doctor's profile and edit doctor's profile.

  Scenario: When name or speciality or street address or postcode or country or phone or email
    or license number are not present
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I fill in "password_again" with "123456"
    And I press "Register"
    And  I go to "/login"
    And I fill in "username" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I press "Login"

    Given I go to "http://127.0.0.1/doctorprofile"
    When I press "post1"
    Then the response status code should be 200
    And I should see "The [name] is required"
    And I should see "The [speciality] is required"
    And I should see "The [street address] is required"
    And I should see "The [postcode] is required"
    And I should see "The [country] is required"
    And I should see "The [phone] is required"
    And I should see "The [email] is required"
    And I should see "The [license number] is required"

  Scenario: When email is wrong format
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I fill in "password_again" with "123456"
    And I press "Register"
    And  I go to "/login"
    And I fill in "username" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I press "Login"
    #to do
    Given I go to "http://127.0.0.1/doctorprofile"
    When I fill in "email" with "joe&&&@@123"
    And I press "post1"
    Then the response status code should be 200
    And I should be on "http://127.0.0.1/doctorprofile"
    And I should see "The email is incorrect email address."

  Scenario: User can register as doctor
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I fill in "password_again" with "123456"
    And I press "Register"
    And  I go to "/login"
    And I fill in "username" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I press "Login"
    #to do
    Given I go to "http://127.0.0.1/doctorprofile"
    When I fill in "name" with "George Washington"
    And  I fill in "speciality" with "the president of The US"
    And  I fill in "street_address" with "the white house"
    And  I select "Bali" from "city_id"
    And  I fill in "postcode" with "330029"
    And  I select "Java" from "province_id"
    And  I fill in "country" with "TheUS"
    And  I fill in "phone" with "13501805331"
    And  I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    And  I fill in "license_number" with "987654321"

    When I press "post1"
    Then the response status code should be 200
    And I should see a record with "name" that is "George Washington" in the "doctors" table in the database
    And I should see a record with "email" that is "GeorgeWashington@aquarius-asia.com" in the "doctors" table in the database
    And I should be on "http://127.0.0.1/doctorprofileedit"

  Scenario: name and email  must be unique
    Given I go to "http://127.0.0.1/register"
    And I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I fill in "password_again" with "123456"
    And I press "Register"
    And  I go to "/login"
    And I fill in "username" with "GeorgeWashington@aquarius-asia.com"
    And I fill in "password" with "123456"
    And I press "Login"
      #to do
    Given I go to "http://127.0.0.1/doctorprofile"
    When I fill in "name" with "Maggie Seaver"
    And  I fill in "email" with "maggie@mail.com"
    And  I press "post1"
    Then the response status code should be 200
    And I should be on "http://127.0.0.1/doctorprofile"
    And I should see "The name already exist in database"
    And I should see "The email already exist in database"

  #Scenario: User can edit doctor profile
    #Given I go to "http://127.0.0.1/register"
    #And I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    #And I fill in "password" with "123456"
    #And I fill in "password_again" with "123456"
    #And I press "Register"
    #And  I go to "/login"
    #And I fill in "username" with "GeorgeWashington@aquarius-asia.com"
    #And I fill in "password" with "123456"
    #And I press "Login"
    #to do

    #Given I go to "http://127.0.0.1/doctorprofile"
    #When I fill in "name" with "George Washington"
    #And  I fill in "speciality" with "the president of The US"
    #And  I fill in "street_address" with "the white house"
    #And  I select "Bali" from "city_id"
    #And  I fill in "postcode" with "330029"
    #And  I select "Java" from "province_id"
    #And  I fill in "country" with "TheUS"
    #And  I fill in "phone" with "13501805331"
    #And  I fill in "email" with "GeorgeWashington@aquarius-asia.com"
    #And  I fill in "license_number" with "987654321"
    #When I press "post1"
    #Then the response status code should be 200
    #And I should see a record with "name" that is "George Washington" in the "doctors" table in the database

    #Given I go to "http://127.0.0.1/doctorprofileedit"
    #Then  I should see "edit doctor"
    #When I fill in "name" with "George Washington2"
    #And  I fill in "speciality" with "the president of The US2"
    #And  I fill in "street_address" with "the white house2"
    #And  I select "Bali" from "city_id"
    #And  I fill in "postcode" with "330029"
    #And  I select "Java" from "province_id"
    #And  I fill in "country" with "TheUS2"
    #And  I fill in "phone" with "13501805331"
    #And  I fill in "email" with "GeorgeWashington2@aquarius-asia.com"
    #And  I fill in "license_number" with "9876543212"

    #When I press "post1"
    #And I should see "George Washington2"
    #And I should see "GeorgeWashington2@aquarius-asia.com"
