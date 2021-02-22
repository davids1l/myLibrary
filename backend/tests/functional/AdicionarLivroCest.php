<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class AdicionarLivroCest
{
    public function _before(FunctionalTester $I)
    {
        $login = new LoginBackendCest();
        $login->FazerLogin($I);
    }

    // tests
    public function AdicionarLivro(FunctionalTester $I)
    {
        $I->see('Livros');
        $I->click('LIVROS');
        $I->see('Inserir Livro');
        $I->click("Inserir Livro");
        $I->see('Escolha a imagem:');
        $I->attachFile('#files', 'imagem.jpg');
        $I->see('Título');
        $I->fillField('Título','Livro do Desassossego');
        $I->fillField('ISBN','123098345');
        $I->fillField('Ano','2005');
        $I->fillField('Nº de Páginas','234');
        $I->fillField('Gênero','Poesia');
        $I->fillField('Idioma','Portugues');
        $I->fillField('Formato','Fisico');
        $I->selectOption('Editora', 1);
        $I->selectOption('Biblioteca', 1);
        $I->selectOption('Autor', 1);
        $I->fillField('Sinopse','Isto é uma sinopse');
        $I->click('Inserir');
    }
}