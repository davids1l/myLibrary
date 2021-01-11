<?php

namespace frontend\controllers;

use Carbon\Carbon;
use Yii;
use app\models\Comentario;
use app\models\ComentarioSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
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
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comentario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComentarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comentario model.
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
     * Função responsável por criar um novo comentário
     * recebe o comentário no post efetuado no form da vista
     * valida a
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($id)
    {
        $model = new Comentario();

        $comentario = Yii::$app->request->post('Comentario');

        $model->dta_comentario = Carbon::now();
        $model->comentario = $comentario;
        $model->id_livro = $id;
        $model->id_utilizador = Yii::$app->user->id;

        if(Yii::$app->user->can('createComentario')){
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->save();
                Yii::$app->session->setFlash('success', 'Obrigado pelo seu comentário!');
                return $this->redirect(['livro/detalhes', 'id' => $id]);
            }
        }

        return $this->redirect(['livro/detalhes', 'id' => $id]);
    }

    /**
     * Updates an existing Comentario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->dta_comentario = Carbon::now();

        if (Yii::$app->user->can('updateComentario') && $this->validateUserAutenticity($model)){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Comentário alterado com sucesso');
            }
        } else {
            Yii::$app->session->setFlash('warning', 'Erro ao alterar comentário');
        }


        return $this->redirect(['livro/detalhes',
            'id' => $model->id_livro]
        );
    }

    //Validar se o user logado é o autor do comentario
    private function validateUserAutenticity($model)
    {
        return Yii::$app->user->id == $model->id_utilizador ? true : false;
    }

    /**
     * Deletes an existing Comentario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->user->can('deleteComentario') && $this->validateUserAutenticity($model)){
            $this->findModel($id)->delete();
        }

        return $this->redirect(['livro/detalhes', 'id' => $model->id_livro]);
    }

    /**
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
