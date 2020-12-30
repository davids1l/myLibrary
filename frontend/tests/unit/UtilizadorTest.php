<?php namespace frontend\tests;

use common\models\User;
use frontend\models\Utilizador;

class UtilizadorTest extends \Codeception\Test\Unit
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
        $utilizador = new Utilizador();

        $utilizador->primeiro_nome = 'testetestetestetestetestetestetestetestetestetestetesteteste';
        $this->assertFalse($utilizador->validate(['primeiro_nome']));

        $utilizador->ultimo_nome = '';
        $this->assertFalse($utilizador->validate(['ultimo_nome']));

        $utilizador->numero = 'a9019321';
        $this->assertFalse($utilizador->validate(['numero']));

        //$utilizador->dta_nascimento = 'vinte de dezembro de dois mil e vinte';
        //$this->assertFalse($utilizador->validate(['dta_nascimento']));

        $utilizador->nif = '1234567890';
        $this->assertFalse($utilizador->validate(['nif']));

        $utilizador->num_telemovel = '1234567890';
        $this->assertFalse($utilizador->validate(['num_telemovel']));
    }

    public function testB_C()
    {
        /*$user = new User();
        $user->username = "username";
        $user->auth_key = "zvo1x0LuaNWF115MojjMg6MKFaNdr-0C";
        $user->password_hash = '$2y$13$eT0yrX2rwu3bFxlksaYVpeEt9QMJfW.TnGbu7i6jMP.KDV8QyAoWy';
        $user->email = "userTestes@gmail.com";
        $user->status = 10;
        $user->created_at = '1608420184';
        $user->updated_at = '1608420184';
        $user->save();*/

        $utilizador = new Utilizador();
        //$utilizador->id_utilizador = $user->id;
        $utilizador->primeiro_nome = "Manuel";
        $utilizador->ultimo_nome = "Garcia";
        $utilizador->numero = "a123";
        $utilizador->dta_nascimento = "1983-04-23";
        $utilizador->nif = "904121236";
        $utilizador->num_telemovel = "910479123";
        $utilizador->save();

        $this->tester->seeInDatabase('utilizador', ['primeiro_nome' => 'Manuel']);
    }

    public function testD_E()
    {
        $utilizador = $this->tester->grabRecord('frontend\models\utilizador', ['primeiro_nome' => 'Manuel']);

        $utilizador->primeiro_nome = "Tiago";
        $utilizador->save(false);

        $this->tester->seeInDatabase('utilizador', ['primeiro_nome' => 'Tiago']);
    }

    public function testF_G()
    {
        $utilizador = $this->tester->grabRecord('frontend\models\utilizador', ['primeiro_nome' => 'Tiago']);

        $utilizador->delete();

        $this->tester->cantSeeInDatabase('utilizador', ['primeiro_nome' =>'Tiago']);
    }
}