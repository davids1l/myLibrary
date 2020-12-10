<?php

namespace frontend\controllers;

use app\models\Biblioteca;
use app\models\Livro;
use Carbon\Carbon;
use Yii;
use app\models\Requisicao;
use app\models\RequisicaoSearch;
use yii\db\Query;
use yii\debug\panels\DumpPanel;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['carrinho', 'remover', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['carrinho', 'remover', 'create', 'update', 'delete'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['carrinho', 'remover', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Função responsavél por adicionar um livro à session do carrinho.
     */
    public function actionCarrinho($id_livro)
    {

        //TODO: Verificar se o livro já se encontra em requisição (ex. query à tabela requisicao_livro)

        //query para encontrar o livro pelo $id
        $livro = Livro::findOne($id_livro);

        //define a variável da sessão
        $session = Yii::$app->session;
        $flag = 0;

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
     *  Função responsável por excluir um livro da session carrinho
     */
    public function actionRemover($id_livro){

        /*
         * 1- validar se a session está open e se contem informação.
         * 2- se true, então foreach em cada objeto do carrinho e validar se id_livro = id_livro
         * 3- se true, é feito um array_search para encontrar o index da posição do array 'carrinho' onde está o objeto
         * 4- com o index obtido é efetuado o unset no array carrinho de acordo com esse index (Remover)
         */

        $session = Yii::$app->session;
        $carrinho = $session->get('carrinho');
        
        if($session->isActive && $carrinho!=null){
            foreach ($carrinho as $obj_livro) {
                if ($obj_livro->id_livro == $id_livro) {
                    $index = array_search($obj_livro, $carrinho);
                    unset($_SESSION['carrinho'][$index]);
                    $session->setFlash('success', 'Livro excluído do carrinho.');
                }
            }
        }

        return $this->redirect(['requisicao/index']);

    }


    /**
     * Lists all Requisicao models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new RequisicaoSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Requisicao();

        $bibliotecas = Biblioteca::find()
            ->all();

        return $this->render('index', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            'model' => $model,
            'bibliotecas' => $bibliotecas
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
        /*
         * TODO:
         * 1- receber o array de sessão carrinho
         * 3- receber o post com os dados p
         * reenchidos da requisição e fazer save
         * 2- foreach a refetuar save na tabela requisicao_livro para cada um dos livros na session carrinho
         *
         * TODO: validar as datas recebidas
         *
         */

        $session = Yii::$app->session;
        $carrinho = $session->get('carrinho');

        $postData = Yii::$app->request->post();
        var_dump($postData);
        die();

        $model = new Requisicao();

        $model->estado = 'Em processamento';
        $model->dta_levantamento = $postData['Requisicao']['dta_levantamento'];
        $model->dta_entrega = $this->gerarDataEntrega($postData['Requisicao']['dta_levantamento']); //Carbon::create(2020, 12, 30, null, null, null); //TODO: função para determinar a data de entrega de acordo com a data de levantamento
        $model->id_livro = 2; //TODO: REMOVER linha! apenas para testes!
        $model->id_utilizador = Yii::$app->user->id;
        $model->id_bib_levantamento = $postData['Requisicao']['id_bib_levantamento'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_requisicao]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Função que determina a data de entrega de acordo com a data de levantamento
     */
    public function gerarDataEntrega($data_levantamento)
    {

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
