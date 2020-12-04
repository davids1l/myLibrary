<?php namespace frontend\tests;

use app\models\Pessoa;
use app\models\Utilizador;

class ExampleTest extends \Codeception\Test\Unit
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
    public function testRegistar(){

        $utilizador = new Utilizador();
        $utilizador->primeiro_nome = "Tiago";
        $utilizador->ultimo_nome = "Lopes";
        $utilizador->dta_nascimento = 2020-11-05;
        $utilizador->num_telemovel = "Leiria";
        $utilizador->nif = 123456789;
        $utilizador->email = "tiago@gmail.com";
        $utilizador->save();

        //$this->tester->canSeeRecord('utilizador',['primeiro_nome' => 'Tiago']);
    }
}