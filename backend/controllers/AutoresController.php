<?php

namespace app\controllers;

namespace backend\controllers;

use app\models\Pais;
use Yii;
use app\Models\Autor;
use app\models\AutorSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AutoresController implements the CRUD actions for Autor model.
 */
class AutoresController extends Controller
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
     * Lists all Autor models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('bibliotecario')) {
            $searchModel = new AutorSearch();
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
     * Displays a single Autor model.
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
     * Creates a new Autor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('createAutor')) {
            $model = new Autor();

            $paises = Pais::find()
                ->orderBy(['id_pais' => SORT_ASC])
                ->all();
            $listPaises = ArrayHelper::map($paises, 'id_pais', 'designacao');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_autor]);
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
     * Updates an existing Autor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('updateAutor')) {
            $model = $this->findModel($id);

            $paises = Pais::find()
                ->orderBy(['id_pais' => SORT_ASC])
                ->all();
            $listPaises = ArrayHelper::map($paises, 'id_pais', 'designacao');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_autor]);
            }

            return $this->render('update', [
                'model' => $model,
                'paises' => $listPaises,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Deletes an existing Autor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteAutor')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Não tens permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Finds the Autor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Autor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Autor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
