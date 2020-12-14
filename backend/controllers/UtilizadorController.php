<?php

namespace app\controllers;
namespace backend\controllers;

use Carbon\Carbon;
use common\models\SignupForm;
use common\models\User;
use Yii;
use app\models\Utilizador;
use app\models\UtilizadorSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UtilizadorController implements the CRUD actions for Utilizador model.
 */
class UtilizadorController extends Controller
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


    public function actionBloquear($id){

        $utilizador = $this->findModel($id);


        if($utilizador->bloqueado == 1){
            $utilizador->bloqueado = null;
            $utilizador->dta_bloqueado = null;
            $utilizador->save();
        }else{
            $utilizador->bloqueado = 1;
            $utilizador->dta_bloqueado = Carbon::now();
            $utilizador->save();
        }

        return $this->actionView($id);
    }

    /**
     * Lists all Utilizador models.
     * @param null $model
     * @return mixed
     */
    public function actionIndex($model = null)
    {
        if($model == null){
            $model = new SignupForm();
        }

        $subQueryRole = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
        $utilizadores = Utilizador::find()->where(['id_utilizador' => $subQueryRole])->orderBy(['id_utilizador' => SORT_ASC])->all();

        return $this->render('index', ['utilizadores' => $utilizadores, 'model' => $model]);
    }

    /**
     * Displays a single Utilizador model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id),]);
    }

    /**
     * Creates a new Utilizador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup(0)) {
            Yii::$app->session->setFlash('success', 'Leitor inserido com sucesso.');
            return $this->actionIndex();
        }

        $model->password = '';
        $model->confirmarPassword = '';
        return $this->actionIndex($model);
    }

    /**
     * Updates an existing Utilizador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_utilizador]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Utilizador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        $user->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Utilizador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Utilizador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Utilizador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
