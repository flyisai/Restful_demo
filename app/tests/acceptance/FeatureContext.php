<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;	
use App\Models\User;

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
}
