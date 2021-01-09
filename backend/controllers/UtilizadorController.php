<?php

namespace app\controllers;

namespace backend\controllers;

use app\models\UtilizadorSearch;
use Carbon\Carbon;
use common\models\SignupForm;
use common\models\User;
use Yii;
use app\models\Utilizador;
use app\models\BibliotecarioSearch;
use yii\db\Query;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'showmodal', 'bloquear', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'showmodal', 'bloquear', 'create', 'update', 'delete'],
                        'allow' => false,
                        'roles' => ['?'],
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


    public function actionBloquear($id)
    {

        if (Yii::$app->user->can('updateLeitor')) {
            $utilizador = $this->findModel($id);

            if ($utilizador->bloqueado == 1) {
                $utilizador->bloqueado = null;
                $utilizador->dta_bloqueado = null;
                $utilizador->save();
            } else {
                $utilizador->bloqueado = 1;
                $utilizador->dta_bloqueado = Carbon::now();
                $utilizador->save();
            }

            return $this->redirect(['index', 'pesquisa' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Lists all Utilizador models.
     * @param null $model
     * @return mixed
     */
    public function actionIndex($model = null, $pesquisa = null)
    {
        if (Yii::$app->user->can('admin') || if (Yii::$app->user->can('bibliotecario')) {
            if ($model == null) {
                $model = new SignupForm();
            }

            $searchModel = new UtilizadorSearch();

            if ($pesquisa != null) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pesquisa);
            } else {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            }

            return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'model' => $model]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
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


    function actionShowmodal($model = null)
    {
        if ($model == null) {
            $model = new SignupForm();
        }

        $searchModel = new UtilizadorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $js = '$("#criarLeitorModal").modal("show")';
        $this->getView()->registerJs($js);
        return $this->render('index', ['model' => $model, 'searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
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
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Ocorreu um erro ao inserir o leitor.');
        $model->password = '';
        $model->confirmarPassword = '';
        return $this->actionShowmodal($model);
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
