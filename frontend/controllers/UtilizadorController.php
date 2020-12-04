<?php

namespace frontend\controllers;

use common\models\UploadForm;
use common\models\User;
use frontend\models\Utilizador;
use Yii;
use app\models\UtilizadorSearch;
use yii\base\ViewRenderer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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

    public function actionRemoverImg($id){
        $utilizador = $this->findModel($id);

        $utilizador->foto_perfil = $utilizador->atribuirImg();
        $utilizador->save();
        return $this->actionPerfil();
    }

    public function actionUploadImg($id)
    {
        $utilizador = $this->findModel($id);
        $model = new UploadForm();

        if (Yii::$app->request->post()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload($utilizador->numero)) {
                $utilizador->foto_perfil = $model->imageFile->name;
                $utilizador->save();
                return $this->actionPerfil();
            }else{
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao inserir a imagem.');
                return $this->actionPerfil();
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao inserir a imagem.');
            return $this->actionPerfil();
        }
    }


    public function actionPerfil()
    {
        $modelUpload = new UploadForm();
        $model = Utilizador::find()->where(['id_utilizador' => Yii::$app->user->identity->id])->one();
        $userModel = User::find()->where(Yii::$app->user->identity->id)->one();

        return $this->render('view', ['model' => $model, 'modelUpload' => $modelUpload, 'userModel' => $userModel]);
    }

    /**
     * Lists all Utilizador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UtilizadorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Utilizador model.
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
     * Creates a new Utilizador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Utilizador();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_utilizador]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
        $user = User::find()->where($id)->one();


        if ($model->load(Yii::$app->request->post())) {

           if ($model->validarNumTelemovel() == false) {
               Yii::$app->session->setFlash('error', 'Número de telemóvel inválido. Insira um número que comece por 9.');
               return $this->actionPerfil();
           }

           if ($model->validarDataNascimento() == false) {
               Yii::$app->session->setFlash('error', 'Data de nascimento inválida. Insira uma data de nascimeto válida');
               return $this->actionPerfil();
           }

           $user->email = Yii::$app->request->post('User')['email'];
           if(!$user->validate()){
               return $this->actionPerfil();
           }

            $user->save();
            $model->save();

            Yii::$app->session->setFlash('success', 'Dados alterados com sucesso!');
            return $this->actionPerfil();
        }

        Yii::$app->session->setFlash('error', 'Ocorreu um erro ao alterar os dados.');
        return $this->actionPerfil();

    }


    public function actionUpdatePassword($id){

        //$user = User::find()->where($id)->one();
        $user = new User();

        if($user->load(Yii::$app->request->post())){


            $user->save();
        }

        Yii::$app->session->setFlash('error', 'Ocorreu um erro ao alterar a palavra-passe.');
        return $this->actionPerfil();
    }



    /**
     * Deletes an existing Utilizador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Utilizador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Utilizador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Utilizador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
