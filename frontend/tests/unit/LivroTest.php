<?php namespace frontend\tests;

use app\models\Autor;
use app\models\Biblioteca;
use app\models\Editora;
use app\models\Livro;
use app\models\Pais;

class LivroTest extends \Codeception\Test\Unit
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
        $livro = new Livro();

        $livro->titulo = null;
        $this->assertFalse($livro->validate(['titulo']));

        $livro->isbn = '495018234534g';
        $this->assertFalse($livro->validate(['isbn']));

        $livro->ano = 'Dois mil e vinte';
        $this->assertFalse($livro->validate(['ano']));

        $livro->paginas = 'Duzentas';
        $this->assertFalse($livro->validate(['paginas']));

        $livro->genero = 320;
        $this->assertFalse($livro->validate(['genero']));

        $livro->idioma = 'Portuguêsêsêsêsês';
        $this->assertFalse($livro->validate(['idioma']));

        $livro->capa = 1231421;
        $this->assertFalse($livro->validate(['capa']));

        $livro->sinopse = 1977;
        $this->assertFalse($livro->validate(['sinopse']));
    }

    public function testB_C()
    {
        $livro = new Livro();
        $livro->titulo = 'Mil Vezes Adeus';
        $livro->isbn = '4193101482371';
        $livro->ano = '2015';
        $livro->paginas = '290';
        $livro->genero = 'Comédia';
        $livro->idioma = 'Português';
        $livro->formato = 'Físico';
        $livro->capa = '4193101482371.png';
        $livro->sinopse = 'O livro retrata...';
        $livro->id_editora = 1;
        $livro->id_biblioteca = 1;
        $livro->id_autor = 1;

        $livro->save();

        $this->tester->seeInDatabase('livro', ['titulo' => 'Mil Vezes Adeus']);
    }

    public function testD_E()
    {
        $livro = $this->tester->grabRecord('app\models\livro', ['titulo' => 'Mil Vezes Adeus']);

        $livro->titulo = 'Mil Vezes Bom Dia';
        $livro->save();

        $this->tester->seeInDatabase('livro', ['titulo' => 'Mil Vezes Bom Dia']);
    }

    public function testF_G()
    {
        $livro = $this->tester->grabRecord('app\models\livro', ['titulo' => 'Mil Vezes Bom Dia']);

        $livro->delete();

        $this->tester->cantSeeInDatabase('livro', ['titulo' =>'Mil Vezes Bom Dia']);
    }
}