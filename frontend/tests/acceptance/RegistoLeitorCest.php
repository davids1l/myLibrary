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
        //Registo de leitor
        $I->amOnPage('/');
        $I->maximizeWindow();
        $I->wait(2);
        $I->click('INICIAR SESSÃO');
        $I->wait(2);
        $I->click(['class' => 'linkRegistar']);
        $I->wait(2);
        $I->fillField('nome','Bartolomeu');
        $I->wait(1);
        $I->fillField('apelido','Dias');
        $I->wait(1);
        $I->fillField('SignupForm[email]','bartolomeudias@gmail.com');
        $I->wait(1);
        $I->fillField('SignupForm[dta_nascimento]','19-04-1991');
        $I->wait(1);
        $I->fillField('NIF','571830992');
        $I->wait(1);
        $I->fillField('nº de telemóvel','915013915');
        $I->wait(1);
        $I->fillField('palavra-passe','123123123');
        $I->wait(1);
        $I->fillField('confirmar palavra-passe','123123123');
        $I->wait(2);
        $I->click('signup-button');
        $I->wait(4);
        $I->see('Obrigado pelo seu registo');
        $I->wait(2);

        //Login de leitor
        $I->click('INICIAR SESSÃO');
        $I->wait(2);
        $I->fillField('LoginForm[email]','bartolomeudias@gmail.com');
        $I->wait(1);
        $I->fillField('LoginForm[password]','123123123');
        $I->wait(1);
        $I->click('login-button');
        $I->wait(5);
        $I->see('Bartolomeu');
        $I->wait(2);


        //Colocar livro nos favoritos e fazer um comentário
        $I->click('CATÁLOGO');
        $I->wait(2);
        $I->click(['class' => 'capa']);
        $I->wait(2);
        $I->click(['class' => 'btnNotFav']);
        $I->wait(2);
        $I->fillField('Comentario[comentario]', 'O melhor livro de fantasia que alguma vez li.');
        $I->wait(2);
        $I->click('comentario');
        $I->wait(2);
        $I->see('Obrigado pelo seu comentário');
        $I->wait(1);
        $I->click('Bartolomeu');
        $I->wait(1);
        $I->click('FAVORITOS');
        $I->wait(2);


        //Fazer logout
        $I->click('Bartolomeu');
        $I->wait(2);
        $I->click('LOGOUT');
        $I->wait(5);
    }
}
