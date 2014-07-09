<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\MinkExtension\Context\MinkContext,
    Behat\Behat\Context\Step\Given,
    Behat\Behat\Context\Step\When,
    Behat\Behat\Context\Step\Then,
    App\Models\User,
    App\Models\DoctorRating;

require_once 'src/Framework/Assert/Functions.php'; // PHPUnit assertions
require_once __DIR__.'/../../../bootstrap/start.php';
require_once __DIR__.'/../../../bootstrap/autoload.php';

/**
 * Features context.
 */
class FeatureContext extends MinkContext {

    /**
     * @static
     * @BeforeSuite
     */
    public static function prepare() {
        error_log(print_r(App::environment()));
        if ((App::environment() == 'production')) {
            dd("Woah there partner! You're on the production server. Running these tests will nuke everything in the DB O_o.");
        }
        /*
        $unitTesting = true;
        $testEnvironment = 'testing';

        // Setup DB
        
        Artisan::call('migrate:install');
        Artisan::call('migrate', array('--package' => 'cartalyst/sentry'));        
        Artisan::call('migrate');
        */
    }

    /**
     * @static
     * @BeforeScenario
     */
    public static function prepDb() {
        Artisan::call('db:seed');
    }

    /**
     * @Given /^I should see a record with "([^"]*)" that is "([^"]*)" in the "([^"]*)" table in the database$/
     */
    public function iShouldSeeARecordWithThatIsInTheTableInTheDatabase($fieldName, $fieldValue, $tableName) {
        $user = DB::table($tableName)->where($fieldName, $fieldValue)->first();
        assertNotEmpty($user);
    }

    /**
     * @Given /^the last log entry should contain "([^"]*)"$/
     */
    public function theLastLogEntryShouldContain($entryPiece) {
        $file = storage_path() . '/logs/laravel.log';
        $data = file($file);
        $line = array_pop($data);
        $entryInLine = (strpos($line, $entryPiece) !== false) ? true : false;
        assertTrue($entryInLine);
    }

    /**
     * @Given /^I open the password reset link for "([^"]*)"$/
     */
    public function iOpenThePasswordResetLinkFor($email) {
        $user = User::where('email', $email)->first();
        $resetLink = 'resetpasswordconfirm/' . $user->reset_password_code;
        $this->visit($resetLink);
    }

    /**
     * @Then /^I should be on the password reset page for "([^"]*)"$/
     */
    public function iShouldBeOnThePasswordResetPageFor($email) {
        $user = User::where('email', $email)->first();
        $resetLink = 'resetpasswordconfirm/' . $user->reset_password_code;   
        $this->assertPageAddress($resetLink);
    }

    /**
     * Click on the element with the provided xpath query
     *
     * @Then /^I should see the element with css "([^"]*)"$/
     */
    public function iCanSeeTheElementWithCSSSelector($cssSelector) {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('css', $cssSelector)
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $cssSelector));
        }
    }

    /**
     * @Then /^I should see a "([^"]*)" model with "([^"]*)" field equal to "([^"]*)" that has "([^"]*)" set to "([^"]*)" respectively$/
     */
    public function iShouldSeeAModelWithFieldEqualToThatHasSetToRespectively($modelName, $searchField, $searchVal, $fieldNames, $fieldValues) {
        $fields = explode(", ", $fieldNames);
        $values = explode(", ", $fieldValues);
        $model = new DoctorRating();
        $actual = $model::where($searchField, $searchVal)->first($fields)->toArray();
        $expected = array_combine($fields, $values);
        assertEquals($expected, $actual);
    }

    /**
     * @Given /^I register and login as "([^"]*)" with password "([^"]*)"$/
     */
    public function iRegisterAndLoginAsWithPassword($username, $password) {
        return array(
            new Given('I go to "http://127.0.0.1/register"'),
            new Then("I fill in \"email\" with \"{$username}\""),
            new Then("I fill in \"password\" with \"{$password}\""),
            new Then("I fill in \"password_again\" with \"{$password}\""),
            new Then('I press "Register"'),
            new Then('I go to "http://127.0.0.1/login"'),
            new Then("I fill in \"username\" with \"{$username}\""),
            new Then("I fill in \"password\" with \"{$password}\""),
            new Then('I press "Login"'),
            new Then("the response status code should be 200")
        );
    }
}
