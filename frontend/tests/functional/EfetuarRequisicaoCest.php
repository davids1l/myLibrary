<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class EfetuarRequisicaoCest
{
    public function _before(FunctionalTester $I)
    {

    }

    // tests
    public function testEfetuarRequisicao(FunctionalTester $I)
    {
        $I->amLoggedInAs(2);
        $I->amOnPage(['livro/detalhes', 'id'=>1]);
        $I->see('Detalhes do livro');
        $I->click( '#adicionarCarrinho');
        $I->seeCurrentUrlEquals('/index-test.php/livro/detalhes?id=1');
        $I->see('Livro adicionado ao seu carrinho!');
        //TODO: click no finalizar requisição do navbar instead of amOnPage<
        //$I->click(['link' => 'Finalizar requisição']);
        $I->amOnPage('requisicao/finalizar');
        $I->seeCurrentUrlEquals('/index-test.php/livro/requisicao/finalizar');
        $I->see('Durante a Queda Aprendi a Voar');

        /* Nenhum destes clicks funciona
        //$I->see('Finalizar', 'button');
        //$I->click(['css' => 'button[type=submit][value=finalizarButton]']);
        //$I->click(['xpath' => '//input[@type="submit"][@form="finalizarButton"]']); //TODO: o finalizar não está a acontecer
        //$I->click('#finalizarButton button[type=submit]'); */

        $I->click(['id'=>'finalizarButton']);

        //$I->submitForm('#formFinalizar', ['id_bib_levantamento' => null]);


        //$I->seeRecord('app\models\RequisicaoLivro', array('id_livro' => '1'));//TODO: fazer um find e uma acerção normal
        $I->seeCurrentUrlEquals('/index-test.php/livro/requisicao/view?id=1');
        //$I->see('Requisição # ');
        $I->see('Obrigado pela sua requisição!');
    }
}
