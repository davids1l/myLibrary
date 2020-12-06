<?php

namespace frontend\controllers;

use app\models\Livro;
use Yii;
use app\models\Requisicao;
use app\models\RequisicaoSearch;
use yii\db\Query;
use yii\debug\panels\DumpPanel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequisicaoController implements the CRUD actions for Requisicao model.
 */
class RequisicaoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Função responsavél por adicionar um livro à sessão do carrinho.
     */
    public function actionCarrinho($id_livro)
    {

        $flag = 0;

        //query para encontrar o livro pelo $id
        $livro = Livro::findOne($id_livro);

        //define a variável da sessão
        $session = Yii::$app->session;

        //$session->destroy();

        //verifica se esta sessão se encontra aberta
        //if($session->isActive) {
            $carrinho = $session->get('carrinho');

            //verifica se o carrinho está null
            if(isset($carrinho)){
                //Limita o carrinho a um máximo de 5 livros
                if(count($carrinho) < 5) {
                    //verifica se o livro a inserir já se encontra no array do carrinho
                    foreach ($carrinho as $obj_livro) {
                        if ($obj_livro->id_livro == $id_livro) {
                            $flag++;
                        }
                    }

                    if ($flag == 0) {
                        $_SESSION['carrinho'][] = $livro;
                        $session->setFlash('success', 'Livro adicionado ao seu carrinho!');
                    } else{
                        $session->setFlash('error', 'Opss! Este livro já se encontra no seu carrinho.');
                    }
                } else {
                    $session->setFlash('error', 'Opss! Limite de livros no carrinho atingido.');
                }

        } else {
            $session->open();
            $_SESSION['carrinho'][] = $livro;
            $session->setFlash('success', 'Livro adicionado ao seu carrinho!');
            $session->close();
        }

        return $this->redirect(['livro/detalhes', 'id' => $id_livro]);
    }


    /**
     * Lists all Requisicao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequisicaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Requisicao model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Requisicao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Requisicao();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_requisicao]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Requisicao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_requisicao]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Requisicao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Requisicao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Requisicao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requisicao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
