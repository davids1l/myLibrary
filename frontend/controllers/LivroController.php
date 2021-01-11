<?php

namespace app\controllers;
namespace frontend\controllers;

use app\models\Comentario;
use app\models\Favorito;
use app\models\Requisicao;
use app\models\RequisicaoLivro;
use Yii;
use app\models\Livro;
use app\models\LivroSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function GuzzleHttp\Psr7\_caseless_remove;

/**
 * LivroController implements the CRUD actions for Livro model.
 */
class LivroController extends Controller
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

    /**
     * Lists all Livro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LivroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * search na BD os livros mais recentes de acordo com a data de edição (ano)
     */
    public function livrosRecentesFilter() {

        $livrosRecentes = Livro::find()
            ->orderBy(['ano' => SORT_DESC, 'id_livro' => SORT_DESC])
            ->limit(6)
            ->all();

        return $livrosRecentes;
    }

    /**
     * @return array
     * Função responsável por listar por ordem descresente os livros com mais requisições
     * recorrendo a uma query que para cada id_livro em requisicao_livro conta o nº de vezes que o mesmo se repete
     */
    public function livrosMaisRequisitados() {

        $query = (new Query())
            ->select(['*' ,'COUNT(*) AS num_requisicoes'])
            ->from('requisicao_livro')
            ->groupBy('id_livro')
            ->orderBy(['num_requisicoes' => SORT_DESC])
            ->limit(6)
            ->all();
        //var_dump($query);die();

        $maisRequisitados = [];
        foreach ($query as $result){
            $livro = Livro::findOne(['id_livro' => $result['id_livro']]);
            array_push($maisRequisitados, $livro);
        }

        return $maisRequisitados;
    }

    public function livrosComMaisFavoritos(){
        /*$query = Favorito::find()
            ->select('*','count(*) AS num_favoritos')
            ->from('favorito')
            ->groupBy('id_livro')
            ->orderBy(['num_favoritos' => SORT_DESC])
            ->limit(6)
            ->all(); */


        $query = (new Query())
            ->select(['*' ,'COUNT(*) AS num_fav'])
            ->from('favorito')
            ->groupBy('id_livro')
            ->orderBy(['num_fav' => SORT_DESC])
            ->limit(6)
            ->all();

        $maisFavoritos = [];
        foreach ($query as $result){
            $livro = Livro::findOne(['id_livro' => $result['id_livro']]);
            array_push($maisFavoritos, $livro);
        }

        return $maisFavoritos;

    }


    /**
     * Displays Catalogo page.
     *
     */
    public function actionCatalogo()
    {
        $model = new Livro();

        $recentes = $this->livrosRecentesFilter();
        $maisRequisitados = $this->livrosMaisRequisitados();
        $maisFavoritos = $this->livrosComMaisFavoritos();

        return $this->render('catalogo', ['model' => $model, 'maisRequisitados' => $maisRequisitados, 'recentes' => $recentes, 'maisFavoritos' => $maisFavoritos]);
    }

    /**
     * @param $id_livro
     * @return bool
     *
     *
     */
    public function verificarEmRequisicao($id_livro){

        //Obter os registos de requisicao_livros em que se verifique id_livro = id_livro recebido por post
        $subQuery = RequisicaoLivro::find()
            ->where(['id_livro' => $id_livro]);

        //Obter as requisições em que o estado seja diferente de "Terminada" e que se verifique que o id_requisicao = id_requesicao da subquery
        $query = Requisicao::find()
            ->where(['!=', 'estado', 'Terminada'])
            ->innerJoin(['sub' => $subQuery], 'requisicao.id_requisicao = sub.id_requisicao')
            ->all();

        //Se o livro não tiver nenhuma requisição com estado concluído implica estar requisitado
        if ($query != null) {
            $canAdicionarCarrinho = false;
        } else {
            $canAdicionarCarrinho = true;
        }

        return $canAdicionarCarrinho;
    }


    /**
     * Recebe um post do form do catalgo e executa a function search no modelo LivroSearch
     *
     */
    public function actionProcurar()
    {
        //$model = new Livro();
        //$params = Yii::$app->request->post();
        //$results = $model->procurar(Yii::$app->request->post());

        $titulo = Yii::$app->request->post()['Livro']['titulo'];

        $query = Livro::find()
            ->where(['like', 'titulo',  $titulo])
            ->all();

        //return $this->redirect('livro/procurar', array('model' => new Livro(), 'results' => $results));
        return $this->render('search', ['model'=> new Livro(), 'results'=>$query]);
    }


    /**
     * Displays detalhes page.
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetalhes($id)
    {
        $modelComentario = new Comentario();

        //find na base de dados do livro com determinado id
        $livro = Livro::findOne($id);

        //request à BD dos comentarios que tem id livro = id
        $comentarios = Comentario::find()
            ->where(['id_livro' => $id])
            ->orderBy('dta_comentario DESC')
            ->all();

        $totalFav = Favorito::find()
            ->where(['id_livro' => $id])
            ->count();

        $fav = Favorito::find()
            ->where(['id_livro' => $id, 'id_utilizador' => Yii::$app->user->id])
            ->one();

        //return da view detalhes com o livro de acordo com o $id recebido
        if(!is_null($livro)){
            return $this->render('detalhes', [
                'livro' => $livro,
                'modelComentario' => $modelComentario,
                'comentarios' => $comentarios,
                'totalFav' => $totalFav,
                //'isFav' => $isFav,
                'favorito' => $fav,
            ]);
        }

        //caso determinado livro não seja encontrado é apresentada a vista de catálogo e uma messagem de erro
        Yii::$app->session->setFlash('error', 'Ocorreu um erro. Tente novamente.');
        return $this->redirect(['livro/catalogo']);
    }


    //TODO: Inutilizado
    /**
     * Displays a single Livro model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    //TODO: Inutilizado
    /**
     * Creates a new Livro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new Livro();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_livro]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/

    //TODO: Inutilizado
    /**
     * Updates an existing Livro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_livro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    //TODO: Inutilizado
    /**
     * Deletes an existing Livro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Livro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Livro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Livro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
