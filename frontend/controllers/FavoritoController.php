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
     * Verifica se o utilizador já tem o livro adiconado aos favoritos
     */
    public function checkFavorito($id)
    {
        //search na BD que verifique dados iguais
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

        //função que valida se já existe um favorito com o mesmo id_user e id_livro
        $alreadyFav = $this->checkFavorito($id);

        //verifica se
        if($alreadyFav == null)
        {
            //if($model->load(Yii::$app->request->post()) && $model->validate())
            $model->dta_favorito = Carbon::now();
            $model->id_livro = $id;
            $model->id_utilizador = Yii::$app->user->id;

            $model->save();
            Yii::$app->session->setFlash('success', 'Livros adicionado aos seus favoritos!');
        }

        return $this->redirect(['livro/detalhes', 'id' => $id]);


        //actionCreate gerado pelo gii CRUD
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
