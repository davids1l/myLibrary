<?php

namespace frontend\controllers;

use app\models\RequisicaoLivro;
use common\models\UploadForm;
use common\models\User;
use frontend\models\Utilizador;
use Yii;
use app\models\BibliotecarioSearch;
use yii\base\ViewRenderer;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'perfil', 'removerImg', 'uploadImg' , 'updatePassword'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'perfil', 'removerImg', 'uploadImg' , 'updatePassword'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['delete', 'index', 'view'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        //'actions' => ['update', 'perfil', 'removerImg'],
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
        $pasta = "perfil";

        if (Yii::$app->request->post()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload($utilizador->numero, $pasta)) {
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
        $userModel = User::find()->where(['id' =>Yii::$app->user->identity->id])->one();

        return $this->render('view', ['model' => $model, 'modelUpload' => $modelUpload, 'userModel' => $userModel]);
    }

    /**
     * Lists all Utilizador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BibliotecarioSearch();
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
        $user = User::find()->where(['id' => $id])->one();

        if(Yii::$app->user->can('updateUtilizador')) {

            if ($model->load(Yii::$app->request->post())) {

                if ($model->validarNumTelemovel() == false) {
                    Yii::$app->session->setFlash('error', 'Número de telemóvel inválido. Insira um número que comece por 9.');
                    return $this->actionPerfil();
                }

                if ($model->validarTamanhoNumTele() == false) {
                    Yii::$app->session->setFlash('error', 'Número de telemóvel inválido. O número tem de ter 9 dígitos.');
                    return $this->actionPerfil();
                }


                if ($model->validarNIF() == false) {
                    Yii::$app->session->setFlash('error', 'NIF inválido. O NIF tem de ter 9 dígitos.');
                    return $this->actionPerfil();
                }

                if ($model->validarDataNascimento() == false) {
                    Yii::$app->session->setFlash('error', 'Data de nascimento inválida. Insira uma data de nascimeto válida.');
                    return $this->actionPerfil();
                }

                $user->email = Yii::$app->request->post('User')['email'];
                if (!$user->validate()) {
                    Yii::$app->session->setFlash('error', 'Email inválido ou já se encontra em utilização.');
                    return $this->actionPerfil();
                }

                $user->save();
                $model->save();

                Yii::$app->session->setFlash('success', '<p id="msg" class="teste">Dados alterados com sucesso!</p>');
                return $this->actionPerfil();
            }

            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao alterar os dados.');
            return $this->actionPerfil();
        }else{
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }


    public function actionUpdatePassword($id){

        $user = User::find()->where($id)->one();


        if(Yii::$app->user->can('updateUtilizador')) {


            if ($user->load(Yii::$app->request->post())) {
                $atualPass = Yii::$app->request->post('User')['atual_password'];
                $novaPass = Yii::$app->request->post('User')['nova_password'];
                $confPass = Yii::$app->request->post('User')['conf_password'];

                if (!$user->validatePassword($atualPass)) {
                    Yii::$app->session->setFlash('error', 'Palavra-passe atual incorreta.');
                    return $this->actionPerfil();
                }

                if ($novaPass != $confPass) {
                    Yii::$app->session->setFlash('error', 'Confirmação de Palavra-passe incorreta.');
                    return $this->actionPerfil();
                }

                $user->password_hash = Yii::$app->security->generatePasswordHash($novaPass);

                if (!$user->validate()) {
                    return $this->actionPerfil();
                }
                $user->save();

                Yii::$app->session->setFlash('success', 'Palavra-passe alterada com sucesso!');
                return $this->actionPerfil();
            }
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao alterar a palavra-passe.');
            return $this->actionPerfil();
        }else{
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
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
