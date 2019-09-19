<?php


use yii\helpers\Url;

class UserCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/index'));
        $I->see('the user index page is work');

        $I->seeLink('Create user');
        $I->click('Create user');
        $I->wait(2); // wait for page to be opened

        $I->see('the user create page is work');
    }
}