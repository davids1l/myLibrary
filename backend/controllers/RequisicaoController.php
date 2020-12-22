<?php

namespace app\controllers;
namespace backend\controllers;

use app\models\Biblioteca;
use app\models\Livro;
use app\models\LivroSearch;
use app\models\RequisicaoLivro;
use app\models\Utilizador;
use Carbon\Carbon;
use Yii;
use app\models\Requisicao;
use app\models\RequisicaoSearch;
use yii\db\Query;
use yii\helpers\ArrayHelper;
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

    public function actionPreparar()
    {
        $searchModel = new RequisicaoSearch();
        $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, 1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionLevantar()
    {
        $searchModel = new RequisicaoSearch();
        $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, 2);

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
        $livro = new Livro();
        $modelReqLivro = new RequisicaoLivro();

        $livros = Livro::find()
            ->orderBy(['titulo' => SORT_ASC])
            ->all();

        $model->dta_levantamento = Carbon::now()->format("Y-m-d\TH:i");
        $model->dta_entrega = Carbon::now()->addDays("30")->format("Y-m-d\TH:i");
        $model->estado = "Em requisição";

        $subQueryRole = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
        $utilizadores = Utilizador::find()
            ->where(['id_utilizador' => $subQueryRole])
            ->orderBy('id_utilizador')
            ->all();
        $listUtilizadores = ArrayHelper::map($utilizadores,'id_utilizador','num_telemovel');

        $bibliotecas = Biblioteca::find()
            ->orderBy(['id_biblioteca' => SORT_ASC])
            ->all();
        $listBibliotecas = ArrayHelper::map($bibliotecas,'id_biblioteca','nome');

        if(Yii::$app->request->post('Livro')['titulo'] != null) {
            $searchModel = new LivroSearch();
            $livros = $searchModel->procurar(Yii::$app->request->post('Livro')['titulo']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_requisicao]);
        }

        return $this->render('create', [
            'model' => $model,
            'utilizadores' => $listUtilizadores,
            'bibliotecas' => $listBibliotecas,
            'livros' => $livros,
            'searchModel' => $livro
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
