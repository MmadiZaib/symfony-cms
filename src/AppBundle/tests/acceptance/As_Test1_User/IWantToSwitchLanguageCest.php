<?php
namespace As_Test1_User;


use AcceptanceTester;
use AppBundle\tests\acceptance\Common;

class IWantToSwitchLanguageCest
{
    public function _before(AcceptanceTester $I)
    {
        Common::login($I, TEST1_USERNAME, TEST1_PASSWORD);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * Given Locale in French
     * When I login and switch language to French
     * Then I should be able to see the dashboard in french till I switched back to english
     * @param AcceptanceTester $I
     */
    public function localeInFrench(AcceptanceTester $I)
    {
        //switch to french
        $I->selectOption('//select[@id="lang"]', 'fr');
        //I should be able to see "my profile" in french
        $I->waitForText("Déconnexion");
        $I->canSee("Déconnexion");
        $I->click('test1');
        //now show profile page
        $I->waitForText('Éditer');
        $I->canSee('Éditer');
        //now switch back to english
        $I->selectOption('//select[@id="lang"]', 'en');
        $I->waitForText('Edit');
        $I->canSee('Edit');

    }
}
