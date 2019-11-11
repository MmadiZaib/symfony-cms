<?php
namespace As_An_Admin;

use AcceptanceTester;
use AppBundle\tests\acceptance\Common;
use Codeception\Util\Locator;

class IWantToManageAllUserCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }


    protected function login(AcceptanceTester $I)
    {
        Common::login($I, ADMIN_USERNAME, ADMIN_PASSWORD);
    }

    /**
     * Scenario: As an Admin, I want to manage all users
     * @before login
     * @param AcceptanceTester $I
     */
    public function listAllProfiles(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/?action=list&entity=User');
        //the magic xpath
        $I->canSeeNumberOfElements('//table/tbody/tr',3);

    }

    /**
     * Scenario : As an Amin, I can manage user test2
     * @before login
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function showTest2User(AcceptanceTester $I)
    {
        //go to user listing page
        $I->amOnPage('/admin/?action=list&entity=User');
        $I->click('Show');
        $I->waitForText('test2@zcms.test');
        $I->canSee('test2@zcms.test');
    }

    /**
     * @before login
     * @param AcceptanceTester $I
     */
    public function editTest2User(AcceptanceTester $I)
    {
        //go to the user listing page
        $I->amOnPage('/admin/?action=list&entity=User');
        $I->click('Edit');
        $I->canSeeInCurrentUrl('/admin/?action=edit&entity=User');
        $I->fillField('//input[@value="test2 LastName"]', 'lastname2 updated');
        //update
        $I->click('//button[@type="submit"]');
        //go back to the listing
        $I->amOnPage('/admin/?action=list&entity=User');
        $I->canSee('lastname2 updated');
        //now revert username
        $I->amOnPage('/admin/?action=edit&entity=User&id=3');
        $I->fillField('//input[@value="lastname2 updated"]', 'test2 Lastname');
        $I->click('//button[@type="submit"]');
        $I->amOnPage('/admin/?action=list&entity=User');
        $I->canSee('test2 Lastname');
    }

    /**
     * @before login
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function createAndDeleteNewUser(AcceptanceTester $I)
    {
        //go to create page and fikk in form
        $I->amOnPage('/admin/?action=new&entity=User');
        $I->fillField('//input[contains(@id, "_username")]', 'test4');
        $I->fillField('//input[contains(@id, "_email")]', 'test4@zcms.test');
        $I->fillField('//input[contains(@id, "_plainPassword_first")]', 'test4');
        $I->fillField('//input[contains(@id, "_plainPassword_second")]', 'test4');
        //submit form
        $I->click('//button[@type="submit"]');
        //go back to user list
        $I->amOnPage('/admin/?entity=User&action=list');
        //I should see new test4 user created
        $I->canSee('test4@zcms.test');
        //now delete user 4
        $I->click('Delete');
        //wait for modal box and the click on the delete button
        $I->waitForElementVisible('//button[@id="modal-delete-button"]');
        $I->click('//button[@id="modal-delete-button"]');
        $I->cantSee('test4@zcms.test');
    }
}
