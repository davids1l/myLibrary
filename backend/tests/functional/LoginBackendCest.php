<?php namespace backend\tests\functional;
use backend\tests\FunctionalTester;

class LoginBackendCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function FazerLogin(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('Email','admin@gmail.com');
        $I->fillField('Palavra-passe', '123123123');
        $I->click('login-button');
        $I->see('Logout');
    }
}
