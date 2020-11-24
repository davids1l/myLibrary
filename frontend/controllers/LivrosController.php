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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['catalogo', 'detalhes'],
                'rules' => [
                    [
                        'actions' => ['catalogo', 'detalhes'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['carrinho'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
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
        //select na BD de todos os livro existentes
        $livros = Livro::find()
            ->orderBy(['titulo' => SORT_ASC])
            ->all();


        return $this->render('catalogo', ['livros' => $livros]);
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
     * Displays Catalogo page.
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
