<?php

namespace backend\controllers;

use Yii;
use app\Models\Biblioteca;
use app\Models\Livro;
use app\models\BibliotecaSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BibliotecasController implements the CRUD actions for Biblioteca model.
 */
class BibliotecasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'catalogo', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'catalogo', 'create', 'update', 'delete'],
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
     * Lists all Biblioteca models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')) {
            $bibliotecas = Biblioteca::find()
                ->orderBy(['id_biblioteca' => SORT_ASC])
                ->all();

            $biblioteca = new Biblioteca();

            return $this->render('index', [
                'bibliotecas' => $bibliotecas,
                'searchModel' => $biblioteca,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Displays a single Biblioteca model.
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

    public function actionCatalogo($id)
    {
        if (Yii::$app->user->can('admin')) {
            $livros = Livro::find()
                ->where(['id_biblioteca' => $id])
                ->orderBy(['titulo' => SORT_ASC])
                ->all();

            $livro = new Livro();

            return $this->render('catalogo', [
                'model' => $this->findModel($id),
                'livros' => $livros,
                'searchModel' => $livro
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }


    /**
     * Creates a new Biblioteca model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Biblioteca();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->user->can('createBiblioteca')) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id_biblioteca]);
            } else {
                Yii::$app->session->setFlash('error', 'Não tem as permissões necessárias para efetuar essa operação.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Biblioteca model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->user->can('updateBiblioteca')) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id_biblioteca]);
            } else {
                Yii::$app->session->setFlash('error', 'Não tem as permissões necessárias para efetuar essa operação.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Biblioteca model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteBiblioteca')) {
            $this->findModel($id)->delete();
        } else {
            Yii::$app->session->setFlash('error', 'Não tem as permissões necessárias para efetuar essa operação.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Biblioteca model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Biblioteca the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Biblioteca::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
