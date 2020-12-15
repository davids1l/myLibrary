<?php

namespace app\controllers;
namespace frontend\controllers;

use app\models\Comentario;
use app\models\Requisicao;
use app\models\RequisicaoLivro;
use Yii;
use app\models\Livro;
use app\models\LivroSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LivroController implements the CRUD actions for Livro model.
 */
class LivroController extends Controller
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
     * Lists all Livro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LivroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * search na BD do últimos 6 livros inseridos
     */
    public function livrosRecentesFilter() {

        $livrosRecentes = Livro::find()
            ->orderBy(['ano' => SORT_DESC]) //TODO:alterar para orderBy(['edicao' => SORT_DESC]);
            ->limit(6)
            ->all();

        return $livrosRecentes;
    }

    public function livrosMaisRequisitados() {

        $query = (new \yii\db\Query())
            ->select(['*' ,'COUNT(*) AS num_requisicoes'])
            ->from('requisicao_livro')
            ->groupBy('id_livro')
            ->orderBy(['num_requisicoes' => SORT_DESC])
            ->limit(6)
            ->all();

        $maisRequisitados = [];
        foreach ($query as $result){
            $livro = Livro::findOne(['id_livro' => $result['id_livro']]);
            array_push($maisRequisitados, $livro);
        }

        return $maisRequisitados;
    }


    /**
     * Displays Catalogo page.
     *
     */
    public function actionCatalogo()
    {
        $model = new Livro();

        //select na BD de todos os livro existentes
        /*$livros = Livro::find()
            ->orderBy(['titulo' => SORT_ASC])
            ->limit(6)
            ->all();*/

        $recentes = $this->livrosRecentesFilter();
        $maisRequisitados = $this->livrosMaisRequisitados();

        return $this->render('catalogo', ['model' => $model, 'maisRequisitados' => $maisRequisitados, 'recentes' => $recentes]);
    }

    /**
     * Recebe um post do form do catalgo e executa a function search no modelo LivroSearch
     *
     */
    public function actionProcurar()
    {
        $model = new LivroSearch();
        $params = Yii::$app->request->post();

        $results = $model->procurar($params);

        return $this->render('search', ['model'=> new Livro(), 'results'=>$results]);
        //return $this->render('view', ['model'=>$searchModel, 'dataProvider'=>$dataProvider]);
    }


    /**
     * Displays detalhes page.
     *
     * @param $id
     * @return string
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


    /**
     * Displays a single Livro model.
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
     * Creates a new Livro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Livro();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_livro]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Livro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_livro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Livro model.
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
     * Finds the Livro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Livro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Livro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
