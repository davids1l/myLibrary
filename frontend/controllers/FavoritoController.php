<?php

namespace frontend\controllers;

use Carbon\Carbon;
use MongoDB\Driver\Session;
use Yii;
use app\models\Favorito;
use app\models\FavoritoSearch;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Link;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\LinkPager;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
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
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FavoritoSearch();

        $session = Yii::$app->session;
        $post = Yii::$app->request->post('listar');

        //se o post!=null, então cria uma variavél de sessão para armazenar o tipo de listagem (SORT_ASC/SORT_DESC) dos favoritos
        //assim quando muda a página na paginação mantem a mesma listagem
        if($post != null){
            $session->isActive ? $_SESSION['favoritoList'] = $post : $session->open();
        }

        $tipoListagem = $session->get('favoritoList');

        /*
         * De acordo com o valor recebido no post é realizada a filtragem pela data mais recente ou mais antiga
         * se o valor recebido for 1, então os livros são listados por ordem decrescente da data
         * se for 2, então os livros são listados por ordem crescente da data
         *
         * SORT_ASC = 4 e SORT_DESC = 3
         */
        switch ($tipoListagem){
            case 1:
                $favoritos = $this->listarPorData(3);
                break;
            case 2:
                $favoritos = $this->listarPorData(4);
                break;
            default:
                $favoritos = Favorito::find()
                    ->where(['id_utilizador' => Yii::$app->user->id]);
        }


        $paginacao = new Pagination(['totalCount' => $favoritos->count(), 'pageSize' => 5]);

        $livros = $favoritos->offset($paginacao->offset)
            ->limit($paginacao->limit)
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'livros' => $livros,
            'paginacao' => $paginacao,
        ]);
    }


    public function listarPorData($sort) {
        $query = Favorito::find()
            ->where(['id_utilizador' => Yii::$app->user->id])
            ->orderBy(['dta_favorito' => $sort]);

        return $query;
    }


    /**
     * Displays a single Favorito model.
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
     * Verifica se o utilizador já tem o livro adiconado aos favoritos
     */
    public function checkFavorito($id)
    {
        //search na BD que verifica se existe algum um registo em que sejam verificados os dois parametros
        $alreadyFav = Favorito::find()
            ->where(['id_livro' => $id, 'id_utilizador' => Yii::$app->user->id])
            ->all();

        return $alreadyFav;
    }


    /**
     * Creates a new Favorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Favorito();

        //valida se já existe um favorito com o mesmo id_user e id_livro
        if($this->checkFavorito($id) == null)
        {
            //if($model->load(Yii::$app->request->post()) && $model->validate())
            $model->dta_favorito = Carbon::now();
            $model->id_livro = $id;
            $model->id_utilizador = Yii::$app->user->id;

            if (Yii::$app->user->can('createFavorito')){
                $model->save();
            }

            //Yii::$app->session->setFlash('success', 'Livro adicionado aos seus favoritos!');
        }

        return $this->redirect(['livro/detalhes', 'id' => $id]);
    }

    /**
     * Updates an existing Favorito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_favorito]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Favorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('deleteFavorito')){
            $model->delete();
        }

        //Yii::$app->request->referrer => retorna a ultima página em que o utilizador esteve
        //se esta for != null então o redirect é feito para a página anteriror
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the Favorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Favorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favorito::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
