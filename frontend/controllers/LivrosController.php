<?php

namespace app\controllers;
namespace frontend\controllers;

use app\models\Livro;
use yii\data\Pagination;
use yii\web\Controller;

class LivrosController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Displays Catalogo page.
     *
     */
    public function actionCatalogo()
    {
        $livros = Livro::find()
            ->orderBy(['titulo' => SORT_ASC])
            ->all();

        //$livros = Livro::findBySql('SELECT * FROM livro WHERE genero LIKE "%Poesia"')->all();

        return $this->render('catalogo', ['livros' => $livros]);
        //return $this->render('catalogo');
    }


    public function actionDetalhes($id)
    {
        //Efetuar o método para mostrar os detalhes do livro quando é clicada a imagem

        //get do $id do livro
        $livro = Livro::findOne($id);

        //return da view de com o livro de acordo com o $id recebido
        return $this->render('detalhes', [
            'livro' => $livro]);
    }
}
