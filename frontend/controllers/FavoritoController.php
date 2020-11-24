<?php

namespace frontend\controllers;

use Carbon\Carbon;
use Yii;
use app\models\Favorito;
use app\models\FavoritoSearch;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
     * Creates a new Favorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Favorito();

        //search na BD por record que verifique dados iguais
        $alreadyFav = Favorito::find()
            ->where(['id_livro' => $id, 'id_utilizador' => 1]) //TODO:alterar id_utilizador para o id do user logado
            ->all();


        //validar se já existe um record com o mesmo id_user e id_livro
        if($alreadyFav == null)
        {
            //if($model->load(Yii::$app->request->post()) && $model->validate())
            $model->data_fav = Carbon::now();
            $model->id_livro = $id;
            $model->id_utilizador = 1; //TODO:: ALTERAR PELO ID DO USER LOGADO!!

            $model->save();
        }

        return $this->redirect(['livros/detalhes', 'id' => $id]);


        //actionCreate favorito gerado pelo gii CRUD
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_favorito]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);*/
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
