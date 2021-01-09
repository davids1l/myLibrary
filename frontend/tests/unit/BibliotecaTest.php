<?php namespace frontend\tests;


use app\models\Biblioteca;

class BibliotecaTest extends \Codeception\Test\Unit
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
        $biblioteca = new Biblioteca();

        $biblioteca->nome = null;
        $this->assertFalse($biblioteca->validate(['nome']));

        $biblioteca->cod_postal = 123345567;
        $this->assertFalse($biblioteca->validate(['cod_postal']));
    }

    public function testB_C()
    {
        $biblioteca = new Biblioteca();

        $biblioteca->nome = 'Biblioteca Distrital de Leiria';
        $biblioteca->cod_postal = '2430-581';

        $biblioteca->save();

        $this->tester->seeInDatabase('biblioteca', ['nome' => 'Biblioteca Distrital de Leiria']);
    }

    public function testD_E()
    {
        $biblioteca = $this->tester->grabRecord('app\models\biblioteca', ['nome' => 'Biblioteca Distrital de Leiria']);

        $biblioteca->nome = 'Biblioteca Municipal de Leiria';
        $biblioteca->save();

        $this->tester->seeInDatabase('biblioteca', ['nome' => 'Biblioteca Municipal de Leiria']);
    }

    public function testF_G()
    {
        $biblioteca = $this->tester->grabRecord('app\models\biblioteca', ['nome' => 'Biblioteca Municipal de Leiria']);

        $biblioteca->delete();

        $this->tester->cantSeeInDatabase('biblioteca', ['nome' =>'Biblioteca Municipal de Leiria']);
    }
}