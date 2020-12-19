<?php

namespace frontend\controllers;

use app\models\Biblioteca;
use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use Yii;
use app\models\Requisicao;
use app\models\RequisicaoSearch;
use yii\db\Exception;
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
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
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


    function actionShowmodal($key){
        $searchModel = new RequisicaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $js='$("#livrosModal").modal("show")';
        $this->getView()->registerJs($js);
        return $this->render('index', ['key' => $key, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }


    public function actionFinalizar()
{
    $model = new Requisicao();

    $bibliotecas = Biblioteca::find()
        ->all();

    $listBib = \yii\helpers\ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

    return $this->render('finalizar', [
        //'searchModel' => $searchModel,
        //'dataProvider' => $dataProvider,
        'model' => $model,
        'bibliotecas' => $listBib
    ]);
}


    /**
     * Lists all Requisicao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequisicaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $key = null;

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $searchModel, 'key' => $key]);
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

        $carrinho = Yii::$app->session->get('carrinho');

        $postData = Yii::$app->request->post();

        /*
        * 1- receber o post
        * 2- array_search do index 2 e ir buscar o id_bib.
        */

        //TODO: validar se livro está em requisicao

        if ($carrinho != null){
            $model = new Requisicao();


            $model->estado = 'A aguardar tratamento';
            //$model->dta_levantamento = null; //$postData['Requisicao']['dta_levantamento'];
            //$model->dta_entrega = null; //$this->gerarDataEntrega($postData['Requisicao']['dta_levantamento']);
            $model->id_utilizador = Yii::$app->user->id;
            $model->id_bib_levantamento = $postData['Requisicao']['id_bib_levantamento'];

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                $this->adicionarRequisicaoLivro($model->id_requisicao, $carrinho);
                Yii::$app->session->destroy();
                Yii::$app->session->setFlash('success', 'Obrigado pela sua requisição!');

                return $this->redirect(['view', 'id' => $model->id_requisicao]);
            } else {
                Yii::$app->session->setFlash('error', 'Ocurreu um problema ao finalizar a sua requisição. Tente novamente!');
                return $this->redirect(['requisicao/finalizar']);
            }
        }
        Yii::$app->session->setFlash('error', 'Ocurreu um problema ao finalizar a sua requisição. Tente novamente!');
        return $this->redirect(['requisicao/finalizar']);
       /*return $this->render('create', [
            'model' => $model,
        ]);*/
    }


    public function adicionarRequisicaoLivro($id_requisicao, $carrinho){
        $requisicaoModel = new RequisicaoLivro();

        //TODO: foreach livro carrinho save requisicao_livro

        //Com foreach-save estava a dar erro
        /*foreach ($carrinho as $livro) {
            $requisicaoModel->id_livro = $livro->id_livro;
            $requisicaoModel->id_requisicao = $id_requisicao;

            $requisicaoModel->save();
        }*/

        /*
         * Insere dados na tabela requisicao_livro com recuro à estrutura Yii DAO(Database Access Objects)
         * recomendado quando o objetivo é inserir multiplos objetos
         */
        foreach ($carrinho as $livro) {
            try {
                Yii::$app->db->createCommand()->insert('requisicao_livro', [
                    'id_livro' => $livro->id_livro,
                    'id_requisicao' => $id_requisicao,
                ])->execute();
            } catch (Exception $e) {
            }
        }
    }


    /**
     * Função que determina a data de entrega de acordo com a data de levantamento
     */
    public function gerarDataEntrega($data_levantamento)
    {
        return date('d/m/Y', strtotime($data_levantamento. ' +30 days'));
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
