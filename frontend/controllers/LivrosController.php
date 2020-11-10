<?php

namespace app\controllers;

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
        $query = Livro::find();

        $pagination = new Pagination([
            'defaultPageSize' => 25,
            'totalCount' => $query->count(),
        ]);

        $livros = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //$livros = Livro::findAll();

        return $this->render('catalogo', [
            'livros' => $livros,
            'pagination' => $pagination,
        ]);
    }


    public function actionDetalhes($id)
    {
        //Efetuar o método para mostrar os detalhes do livro quando é clicada a imagem

        //get do $id do livro
        $livro = Livro::findOne($id);

        //return da view de com o livro de acordo com o $id recebido
        return $this->render('catalogo', ['livro' => $livro]);
    }
}
