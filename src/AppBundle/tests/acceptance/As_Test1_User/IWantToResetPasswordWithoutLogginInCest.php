<?php
namespace AS_Test1_User;


use AcceptanceTester;
use AppBundle\tests\acceptance\Common;

class IWantToResetPasswordWithoutLogginInCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // login
    public function login(AcceptanceTester $I)
    {
        Common::login($I,TEST1_USERNAME, TEST1_PASSWORD);
    }

    /**
     * Given reset password successfully
     * when I click on forget password in the login page and go through  the whole resetting process
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function resetPasswordSuccessfully(AcceptanceTester $I)
    {
        /** TO DO page 25 **/
        //reset emails
        $I->deleteAllEmails();
        $I->amOnPage('/login');
        $I->click('forget password');
        $I->fillField('//input[@id="username"]', 'test1');
        $I->click('_submit');
        $I->canSeeInCurrentUrl('/resetting/check-email?username=test1');
        $I->waitForText('An email has been sent');

        //clear old email from mailhog

        //the password has been reset successfully

        //at dashboard, i should see access denied

        //now login with the new password

        //db has bee changed update it back

        //I am on the show page
    }
}
