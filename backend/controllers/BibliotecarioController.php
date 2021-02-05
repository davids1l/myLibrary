<?php

namespace app\controllers;

namespace backend\controllers;

use app\models\Biblioteca;
use common\models\SignupForm;
use common\models\User;
use Yii;
use app\models\Utilizador;
use app\models\BibliotecarioSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BibliotecarioController implements the CRUD actions for Utilizador model.
 */
class BibliotecarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'showmodal', 'bloquear', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'showmodal', 'update-biblioteca', 'remover-biblioteca', 'bloquear', 'create', 'update', 'delete'],
                        'allow' => false,
                        'roles' => ['?', 'bibliotecario'],
                    ],
                    [
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
     * Lists all Utilizador models.
     * @return mixed
     */
    public function actionIndex($model = null)
    {
        if (Yii::$app->user->can('admin')) {
            if ($model == null) {
                $model = new SignupForm();
            }

            $searchModel = new BibliotecarioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $bibliotecas = Biblioteca::find()->all();

            $listBib = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

            return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model, 'bibliotecas' => $listBib]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }


    function actionShowmodal($model = null)
    {
        if ($model == null) {
            $model = new SignupForm();
        }

        $searchModel = new BibliotecarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $bibliotecas = Biblioteca::find()->all();

        $listBib = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

        $js = '$("#criarBibliotecarioModal").modal("show")';
        $this->getView()->registerJs($js);
        return $this->render('index', ['model' => $model, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'bibliotecas' => $listBib]);
    }

    /**
     * Displays a single Utilizador model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('admin')) {
            $bibliotecas = Biblioteca::find()
                ->orderBy(['id_biblioteca' => SORT_ASC])
                ->all();
            $listBibliotecas = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

            return $this->render('view', ['model' => $this->findModel($id), 'bibliotecas' => $listBibliotecas]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }

    }

    /**
     * Creates a new Utilizador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('createBibliotecario')) {
            $model = new SignupForm();

            $bibliotecas = Biblioteca::find()->all();

            $listBib = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

            if ($model->load(Yii::$app->request->post())) {

                $biblioteca = Yii::$app->request->post();
                $model->id_biblioteca = $biblioteca['SignupForm']['id_biblioteca'];

                if ($model->signup(1)) {
                    Yii::$app->session->setFlash('success', 'Bibliotecário inserido com sucesso.');
                    return $this->redirect(['index']);
                }
            }


            $model->password = '';
            $model->confirmarPassword = '';
            return $this->render('create', ['model' => $model, 'bibliotecas' => $listBib]);

        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }

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
        if (Yii::$app->user->can('updateBibliotecario')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_utilizador]);
            }

            return $this->render('update', ['model' => $model,]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    public function actionUpdateBiblioteca($id)
    {
        if (Yii::$app->user->can('updateBibliotecario')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_utilizador]);
            }
            Yii::$app->session->setFlash('error', 'Biblioteca inserida inválida.');
            return $this->render('view', ['id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }

    }


    public function actionRemoverBiblioteca($id)
    {
        if (Yii::$app->user->can('updateBibliotecario')) {
            $model = $this->findModel($id);

            $model->id_biblioteca = null;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_utilizador]);
        } else {
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
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteBibliotecario')) {
            $user = User::find()->where(['id' => $id])->one();
            $user->delete();

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
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
