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
        $I->see('Bibliotecários');
        $I->click('BIBLIOTECÁRIOS');
        $I->see('Inserir Bibliotecário');
        $I->click(['id' => 'inserirBibliotecario']);
        $I->see('Nome');
        $I->fillField('Nome','Maria');
        $I->fillField('Apelido','Silva');
        $I->fillField('Endereço de email','mariasilva@gmail.com');
        $I->fillField('Data de Nascimento','14/07/1999');
        $I->fillField('NIF','901249120');
        $I->fillField('Nº de telefone','912051286');
        $I->selectOption('Biblioteca', 1);
        $I->fillField('Palavra-Passe','123123123');
        $I->fillField('Confirmar Palavra-Passe','123123123');
        $I->click('formInserirBibliotecario');
        $I->see('Bibliotecário inserido com sucesso.');
    }
}
