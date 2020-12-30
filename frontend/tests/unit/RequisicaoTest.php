<?php namespace frontend\tests;

use app\models\Biblioteca;
use app\models\Requisicao;
use common\models\User;
use frontend\models\Utilizador;

class RequisicaoTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testA()
    {
        $requisicao = new Requisicao();

        /*$requisicao->dta_levantamento = null;
        $this->assertFalse($requisicao->validate(['dta_levantamento']));

        $requisicao->dta_entrega = null;
        $this->assertFalse($requisicao->validate(['dta_entrega']));*/

        $requisicao->estado = 1;
        $this->assertFalse($requisicao->validate(['estado']));

        $requisicao->id_utilizador = 'a312';
        $this->assertFalse($requisicao->validate(['id_utilizador']));

        $requisicao->id_bib_levantamento = 'Biblioteca Municipal de Lisboa';
        $this->assertFalse($requisicao->validate(['id_bib_levantamento']));
    }

    public function testB_C()
    {
        /*$biblioteca = new Biblioteca();
        $biblioteca->nome = 'Biblioteca Requisição';
        $biblioteca->cod_postal = '2431-581';
        $biblioteca->save();

        $user = new User();
        $user->username = "requisicao";
        $user->auth_key = "zvo1x0LuaNWF115MojjMg6MKFaNdr-0C";
        $user->password_hash = '$2y$13$eT0yrX2rwu3bFxlksaYVpeEt9QMJfW.TnGbu7i6jMP.KDV8QyAoWy';
        $user->email = "requisicao@gmail.com";
        $user->status = 10;
        $user->created_at = '1608420184';
        $user->updated_at = '1608420184';
        $user->save();

        $utilizador = new Utilizador();
        $utilizador->id_utilizador = $user->id;
        $utilizador->primeiro_nome = "Maria";
        $utilizador->ultimo_nome = "Graça";
        $utilizador->numero = $utilizador->gerarNumeroLeitor();
        $utilizador->dta_nascimento = "1983-04-23";
        $utilizador->nif = "904412236";
        $utilizador->num_telemovel = "910479123";
        $utilizador->save();*/

        $requisicao = new Requisicao();
        $requisicao->dta_levantamento = '2020-12-01 12:37:36';
        $requisicao->dta_entrega = '2020-12-31 14:30:04';
        $requisicao->estado = 'Em requisição';
        $requisicao->id_utilizador = 7;
        $requisicao->id_bib_levantamento = 7;
        $requisicao->save();

        $this->tester->seeInDatabase('requisicao', ['estado' => 'Em requisição']);
    }

    public function testD_E()
    {
        $requisicao = $this->tester->grabRecord('app\models\requisicao', ['estado' => 'Em requisição']);

        $requisicao->estado = "Terminada";
        $requisicao->save();

        $this->tester->seeInDatabase('requisicao', ['estado' => 'Terminada']);
    }

    public function testF_G()
    {
        $requisicao = $this->tester->grabRecord('app\models\requisicao', ['estado' => 'Terminada']);

        $requisicao->delete();

        $this->tester->cantSeeInDatabase('requisicao', ['estado' => 'Terminada']);
    }
}