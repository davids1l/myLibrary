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
    public function testSomeFeature()
    {
        $this->createComentario();
    }


    public function testValidarComentario()
    {

    }


    public function createComentario()
    {
        $comentario = new Comentario();

        $comentario->dta_comentario = Carbon::now();
        $comentario->comentario = 'Teste Unitário - Comentário';
        $comentario->id_livro = 1;
        $comentario->id_utilizador = 1;

        $comentario->save();

        $this->tester->seeInDatabase('comentario', ['comentario' => 'Teste Unitário - Comentário']);

    }
}