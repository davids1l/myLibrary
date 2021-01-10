<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class AdicionarComentarioCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function testAdicionarComentario(FunctionalTester $I){
        $I->amLoggedInAs(1);
        $I->amOnPage(['livro/detalhes', 'id'=>1]);
        $I->see('Comentário');
        $I->fillField('#comentarioField', 'Teste Funcional - Comentar');
        $I->see('Teste Funcional - Comentar', '#comentarioField');
        $I->click(['id'=>'submitComentario']);
            //$I->submitForm('#formComentar', ['comentario' => 'Teste Funcional - Comentar']);
        $I->see('Obrigado pelo seu comentário!');
    }
}
