<?php namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;

class RegistoLeitorCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }
}
