<?php

namespace app\controllers;

namespace backend\controllers;

use app\models\Pais;
use Yii;
use app\Models\Editora;
use app\models\EditoraSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EditorasController implements the CRUD actions for Editora model.
 */
class EditorasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
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

    /**
     * Lists all Editora models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('bibliotecario')) {

            $searchModel = new EditoraSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Displays a single Editora model.
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
     * Creates a new Editora model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('createEditora')) {
            $model = new Editora();

            $paises = Pais::find()
                ->orderBy(['id_pais' => SORT_ASC])
                ->all();
            $listPaises = ArrayHelper::map($paises, 'id_pais', 'designacao');


            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }

            return $this->render('create', [
                'model' => $model,
                'paises' => $listPaises,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Updates an existing Editora model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('updateEditora')) {
            $model = $this->findModel($id);

            $paises = Pais::find()
                ->orderBy(['id_pais' => SORT_ASC])
                ->all();
            $listPaises = ArrayHelper::map($paises, 'id_pais', 'designacao');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }

            return $this->render('update', [
                'model' => $model,
                'paises' => $listPaises
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Deletes an existing Editora model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteEditora')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Finds the Editora model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Editora the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Editora::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
