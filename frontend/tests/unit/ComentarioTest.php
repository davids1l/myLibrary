<?php namespace frontend\tests;

use app\models\Comentario;
use Carbon\Carbon;

class ComentarioTest extends \Codeception\Test\Unit
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
    /*public function testValidarDataComentario()
    {
        $comentario = new Comentario();

        //DEFAULT CURRENT TIMESTAMP -> pode ser essa a razão de null = true
        //$comentario->dta_comentario = null;
        //$this->assertFalse($comentario->validate(['dta_comentario'])); //=>assertFalse

        $comentario->dta_comentario = 'asdasdasdasdasdasdasdasdasdasd';
        $this->assertFalse($comentario->validate(['dta_comentario'])); //=>assertFalse

        $comentario->dta_comentario = '2020-12-21 11:43:26';
        $this->assertTrue($comentario->validate(['dta_comentario']));

    }*/


    public function testValidarComentario()
    {
        $comentario = new Comentario();

        $comentario->comentario = null;
        $this->assertFalse($comentario->validate(['comentario']));

        $comentario->comentario = 'Teste Comentário - Validar Comentario (Teste Unitário)';
        $this->assertTrue($comentario->validate(['comentario']));

    }


    public function testCreateComentario()
    {
        $comentario = new Comentario();

        $comentario->dta_comentario = Carbon::now();
        $comentario->comentario = 'Teste Unitário - Comentário';
        $comentario->id_livro = 1;
        $comentario->id_utilizador = 1;

        $comentario->save();

        $this->tester->seeInDatabase('comentario', ['comentario' => 'Teste Unitário - Comentário']);

    }

    public function testUpdateComentario()
    {
        $comentario = $this->tester->grabRecord('app\models\comentario', ['comentario' => 'Teste Unitário - Comentário']);
        $comentario->comentario = 'Teste Unitário - Comentário Updated';
        $comentario->save();
        $this->tester->seeInDatabase('comentario', ['comentario' => 'Teste Unitário - Comentário Updated']);
    }

    public function testDeleteComentario()
    {
        $comentario = $this->tester->grabRecord('app\models\comentario', ['comentario' => 'Teste Unitário - Comentário Updated']);
        $comentario->delete();
        $this->tester->dontSeeInDatabase('comentario', ['comentario' => 'Teste Unitário - Comentário Updated']);
    }
}