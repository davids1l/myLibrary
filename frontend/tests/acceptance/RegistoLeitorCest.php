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
        $I->click('Iniciar Sessão/Registar');
        $I->wait(2);
        $I->click(['class' => 'nav-item-registar']);
        $I->wait(2);
        $I->fillField('Primeiro nome','Bartolomeu');
        $I->wait(1);
        $I->fillField('Apelido','Dias');
        $I->wait(1);
        $I->fillField('SignupForm[email]','bartolomeudias@gmail.com');
        $I->wait(1);
        $I->fillField('Data de Nascimento','19-04-1991');
        $I->wait(1);
        $I->fillField('NIF','571830992');
        $I->wait(1);
        $I->fillField('Nº de telefone','915013915');
        $I->wait(1);
        $I->fillField('Palavra-Passe','123123123');
        $I->wait(1);
        $I->fillField('Confirmar Palavra-Passe','123123123');
        $I->wait(2);
        $I->click('signup-button');
        $I->wait(4);
        $I->see('Obrigado pelo seu registo');
        $I->wait(2);

        //Login de leitor
        $I->click('Iniciar Sessão/Registar');
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
        $I->click('Catálogo');
        $I->wait(2);
        $I->click(['class' => 'capa']);
        $I->wait(2);
        $I->click(['class' => 'btnAction']);
        $I->wait(2);
        $I->fillField('Comentario[comentario]', 'O melhor livro de fantasia que alguma vez li.');
        $I->wait(2);
        $I->click('comentario');
        $I->wait(2);
        $I->see('Obrigado pelo seu comentário');
        $I->wait(1);
        $I->click('Bartolomeu');
        $I->wait(1);
        $I->click('Favoritos');
        $I->wait(2);


        //Fazer logout
        $I->click('Bartolomeu');
        $I->wait(2);
        $I->click('Logout');
        $I->wait(5);
    }
}
