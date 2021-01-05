<?php namespace backend\tests\functional;
use backend\tests\FunctionalTester;

class InserirBibliotecarioCest
{
    public function _before(FunctionalTester $I)
    {
        $login = new LoginBackendCest();
        $login->FazerLogin($I);
    }

    // tests
        public function InserirBibliotecario(FunctionalTester $I)
    {
        $I->see('Gerir Bibliotecários');
        $I->click('Gerir Bibliotecários');
        $I->see('Inserir Bibliotecário');
        $I->click("inserirBibliotecario");
        $I->see('Primeiro nome');
        $I->fillField('Primeiro nome','Maria');
        $I->fillField('Apelido','Silva');
        $I->fillField('Email','mariasilva@gmail.com');
        $I->fillField('Data de Nascimento','14/07/1999');
        $I->fillField('NIF','901249120');
        $I->fillField('Nº de telefone','912051286');
        $I->selectOption('Biblioteca', 'Biblioteca Municipal de Lisboa');
        $I->fillField('Palavra-Passe','123123123');
        $I->fillField('Confirmar Palavra-Passe','123123123');
        $I->click('inserirBibliotecario');
        //$I->see('Bibliotecário inserido com sucesso.', '.alert-success alert fade in');
    }
}
