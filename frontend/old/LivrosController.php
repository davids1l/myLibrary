<?php

namespace app\controllers;
namespace frontend\controllers;

use app\models\Comentario;
use app\models\ComentarioSearch;
use app\models\Livro;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LivrosController extends Controller
{


    /**
     * search na BD do últimos 10 livros inseridos
     */
    public function livrosRecentesFilter() {

        $livrosRecentes = Livro::find()
            ->orderBy(['id_livro' => SORT_DESC])
            ->all();


        return $livrosRecentes;

    }


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

        $model = new Livro();

        //select na BD de todos os livro existentes
        $livros = Livro::find()
            ->orderBy(['titulo' => SORT_ASC])
            ->all();

        $recentes = $this->livrosRecentesFilter();

        //echo $recentes;
        return $this->render('catalogo', ['livros' => $livros, 'model' => $model, 'recentes' => $recentes]);
    }


    //TODO: Adicionar elementos ao carrinho (Session Storage)
    public function actionCarrinho()
    {
        $session = Yii::$app->session;

        if ($session->isActive){
            $session->open();
        }
    }


    /**
     * Displays detalhes page.
     *
     * @throws NotFoundHttpException
     */
    public function actionDetalhes($id)
    {

        $model = new Comentario();

        //find na base de dados do livro com determinado id
        $livro = Livro::findOne($id);

        //request à BD dos comentarios que tem id livro = id
        $comentarios = Comentario::find()
            ->where(['id_livro' => $id])
            ->orderBy('dta_comentario DESC')
            ->all();


        if($livro != null && $model!= null){
            //return da view detalhes com o livro de acordo com o $id recebido
            return $this->render('detalhes', [
                'livro' => $livro,
                'model' => $model,
                'comentarios' => $comentarios,
            ]);
        }

        //caso determinado livro não seja encontrado é retornado o erro 404 not found
        throw new NotFoundHttpException('O livro não foi encontrado.');
    }

}
