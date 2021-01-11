<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class AlterarDadosPerfilCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Iniciar Sessão/Registar');
        $I->fillField('Email','admin@admin.com');
        $I->fillField('Palavra-passe', '123123123');
        $I->click('login-button');
        $I->see('Logout');

    }

    // tests
    public function testAlterarDadosPerfil(FunctionalTester $I)
    {
        $I->amOnPage(['utilizador/perfil']);
        $I->see('Perfil de Leitor');
        $I->click(['id' => 'alterarDados']);
        $I->submitForm('#formAlterar', ['utilizador-primeiro_nome' => 'primeiro', 'utilizador-ultimo_nome' => 'apelido',
            'user-email' => 'email@gmail.com', 'utilizador-num_telemovel' => '915831234',
            'utilizador-dta_nascimento' => '25/02/2001', 'utilizador-nif' => '919191919']);
        $I->see('Dados alterados com sucesso!');
    }
}
