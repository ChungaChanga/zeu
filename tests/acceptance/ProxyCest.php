<?php


use yii\helpers\Url;

class ProxyCest
{
    public function ensureThatProxyPageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/proxy/index'));
        $I->see('the proxy index page is work');

        $I->seeLink('Create proxy');
        $I->click('Create proxy');
        $I->wait(2); // wait for page to be opened

        $I->see('the proxy create page is work');
    }
}