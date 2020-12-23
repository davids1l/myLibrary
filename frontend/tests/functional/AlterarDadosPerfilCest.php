<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class AlterarDadosPerfilCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Iniciar Sessão/Registar');
        $I->fillField('Email','admin@gmail.com');
        $I->fillField('Palavra-passe', '123123123');
        $I->click('login-button');
        $I->see('Logout');
        $I->amOnPage(['utilizador/perfil']);
    }

    // tests
    public function AlterarDadosPerfil(FunctionalTester $I)
    {
        $I->see('Perfil de Leitor');
        $I->click(['id' => 'alterarDados']);
        $I->fillField(['id' => 'utilizador-primeiro_nome'], 'primeiro');
        $I->fillField(['id' => 'utilizador-ultimo_nome'], 'apelido');
        $I->fillField(['id' => 'user-email'], 'email@gmail.com');
        $I->fillField(['id' => 'utilizador-num_telemovel'], '919191919');
        $I->fillField(['id' => 'utilizador-dta_nascimento'], '25/02/2001');
        $I->fillField(['id' => 'utilizador-nif'], '919191919');
        $I->click('Guardar Alterações');
        $I->see('Dados alterados com sucesso!');
    }
}
