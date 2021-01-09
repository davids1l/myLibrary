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
        $I->see('Gerir Livros');
        $I->click('Gerir Livros');
        $I->see('Adicionar Livros');
        $I->click("Adicionar Livros");
        $I->see('Escolha a imagem:');
        $I->attachFile('#files', 'imagem.jpg');
        $I->see('Titulo');
        $I->fillField('Titulo','Livro do Desassossego');
        $I->fillField('Isbn','123098345');
        $I->fillField('Ano','2005');
        $I->fillField('Paginas','234');
        $I->fillField('Genero','Poesia');
        $I->fillField('Idioma','Portugues');
        $I->fillField('Formato','Fisico');
        $I->selectOption('Editora', 'Porto Editora');
        $I->selectOption('Biblioteca', 'Biblioteca Municipal Nº5');
        $I->selectOption('Autor', 'Fernando Pessoa');
        $I->fillField('Sinopse','Isto é uma sinopse');
        $I->click('Guardar');
    }
}