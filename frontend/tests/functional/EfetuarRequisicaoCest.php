<?php namespace frontend\tests\functional;
use app\models\Livro;
use frontend\tests\FunctionalTester;

class EfetuarRequisicaoCest
{
    public function _before(FunctionalTester $I)
    {

    }

    // tests
    public function testEfetuarRequisicao(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage(['livro/detalhes', 'id'=>1]);
        $I->see('Detalhes do livro');
        $I->click( '#adicionarCarrinho');
        //$I->setCookie('carrinho', Livro::find()->where(['id_livro' => 1])->one());
        $I->seeCurrentUrlEquals('/index-test.php/livro/detalhes?id=1');
        $I->see('Livro adicionado ao seu carrinho!');
        $I->click(['id' => 'carrinhoLivros']);
        $I->click('Finalizar requisição');
        $I->seeCurrentUrlEquals('/index-test.php/requisicao/finalizar');
        $I->click(['id' => 'finalizarButton']);
        $I->see('Obrigado pela sua requisição!');
    }
}
