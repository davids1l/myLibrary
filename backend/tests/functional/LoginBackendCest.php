<?php namespace backend\tests\functional;
use backend\tests\FunctionalTester;
use common\models\SignupForm;
use common\models\User;

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
        $I->fillField('Email','admin@admin.com');
        $I->fillField('Palavra-passe', 'qwerty1234');
        $I->click('login-button');
        $I->see('Logout');
    }
}
