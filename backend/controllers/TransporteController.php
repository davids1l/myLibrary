<?php

namespace backend\controllers;

use app\models\Livro;
use app\models\TransporteLivro;
use app\models\TransporteSearch;
use Carbon\Carbon;
use Yii;
use app\models\Transporte;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransporteController implements the CRUD actions for Transporte model.
 */
class TransporteController extends Controller
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


    public function actionTratar($id)
    {
        $transporte = Transporte::find()->where(['id_transporte' => $id])->one();

        $livrosTransporte = $this->obterLivrosTransporte($id);

        return $this->render('tratar', ['transporte' => $transporte, 'livrosTransporte' => $livrosTransporte]);
    }

    public function actionReceber($id) {

        $livrosTransporte = $this->obterLivrosTransporte($id);

        return $this->render('receber', ['transporte' => $id, 'livrosTransporte' => $livrosTransporte]);
    }

    public function obterLivrosTransporte($id_transporte) {

        $sub = TransporteLivro::find()->where(['id_transporte' => $id_transporte]);

        $livrosTransporte = Livro::find()->innerJoin(['sub' => $sub], 'sub.id_livro=livro.id_livro')->all();

        return $livrosTransporte;
    }


    /**
     * Lists all Transporte models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Transporte::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transporte model.
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
     * Creates a new Transporte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transporte();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_transporte]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transporte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $livrosTransporte = $this->obterLivrosTransporte($id);

        if($model->estado == "A aguardar tratamento"){
            $model->estado = "Em transporte";
            $model->dta_despacho = Carbon::now();

            //if (Yii::$app->user->can('updateTransporte')) {
            $model->save();
            //}
        } elseif ($model->estado == "Em transporte") {

            $model->estado = "Concluído";
            $model->dta_recebida = Carbon::now();
            $model->save();

            //Mudar o id_bib de cada um dos livros do transporte
            foreach ($livrosTransporte as $livro){
                if(Yii::$app->user->can('updateLivro')){
                    $livro->id_biblioteca = $model->id_bib_recetora;
                    $livro->save();
                }
            }

        }

        /*return $this->render('index', [
            'model' => $model,
        ]);*/

        return $this->redirect('../site/index');
    }



    /**
     * Deletes an existing Transporte model.
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
     * Finds the Transporte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transporte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transporte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
