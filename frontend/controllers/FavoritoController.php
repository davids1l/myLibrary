<?php

namespace frontend\controllers;

use Carbon\Carbon;
use Yii;
use app\models\Favorito;
use app\models\FavoritoSearch;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
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
     * Lists all Favorito models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FavoritoSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $favoritos = Favorito::find()
            ->where(['id_utilizador' => Yii::$app->user->id]);

        $total = $favoritos->count();
        $paginacao = new Pagination(['totalCount' => $total]);
        $models = $favoritos->offset($paginacao->offset)
            ->limit($paginacao->limit)
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            //'favoritos' => $favoritos,
            'models' => $models,
            'paginacao' => $paginacao,
        ]);
    }

    /**
     * Displays a single Favorito model.
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
     * Verifica se o utilizador já tem o livro adiconado aos favoritos
     */
    public function checkFavorito($id)
    {
        //search na BD que verifica se existe algum um registo em que sejam verificados os dois parametros
        $alreadyFav = Favorito::find()
            ->where(['id_livro' => $id, 'id_utilizador' => Yii::$app->user->id])
            ->all();

        return $alreadyFav;
    }


    /**
     * Creates a new Favorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Favorito();

        //valida se já existe um favorito com o mesmo id_user e id_livro
        if($this->checkFavorito($id) == null)
        {
            //if($model->load(Yii::$app->request->post()) && $model->validate())
            $model->dta_favorito = Carbon::now();
            $model->id_livro = $id;
            $model->id_utilizador = Yii::$app->user->id;

            $model->save();
            //Yii::$app->session->setFlash('success', 'Livro adicionado aos seus favoritos!');
        }

        return $this->redirect(['livro/detalhes', 'id' => $id]);
    }

    /**
     * Updates an existing Favorito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_favorito]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Favorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        //return $this->redirect(Yii::$app->request->urlReferrer);
        return $this->redirect(['favorito/index', 'id' => $model->id_livro]);
    }

    /**
     * Finds the Favorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Favorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favorito::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
