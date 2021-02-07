<?php

namespace app\controllers;

namespace backend\controllers;

use app\models\Biblioteca;
use app\models\Editora;
use app\models\Autor;
use app\models\Requisicao;
use app\models\RequisicaoLivro;
use app\models\Utilizador;
use common\models\UploadForm;
use Yii;
use app\models\Livro;
use app\models\LivroSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * LivrosController implements the CRUD actions for Livros model.
 */
class LivrosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'requisitado', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'requisitado', 'create', 'update', 'delete'],
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
     * Lists all Livros models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('bibliotecario')) {
            $livros = Livro::find()
                ->orderBy(['titulo' => SORT_ASC])
                ->all();

            $generos = $this->obterGenerosLivros();

            if (Yii::$app->request->post('Livros')['titulo'] != null) {
                $searchModel = new LivroSearch();
                $livros = $searchModel->procurar(Yii::$app->request->post('Livros')['titulo']);
            }

            $livro = new Livro();

            return $this->render('index', [
                'livros' => $livros,
                'searchModel' => $livro,
                'generos' => $generos
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }

    }

    public function obterGenerosLivros() {

        $query = (new yii\db\Query())
            ->select('genero')
            ->distinct('genero')
            ->from('livro')
            ->all();

        $generos = [];

        for ($i=0; $i < sizeof($query); $i++){
            array_push($generos, $query[$i]['genero']);
        }

        return $generos;
    }

    public function actionProcurar()
    {
        //se for efetuado um pedido à página em que o post seja null, estão os dados são igualados a empty
        if(Yii::$app->request->post() != null){
            $pesquisa = Yii::$app->request->post()['Livro']['titulo'];
            $generoProcurado = Yii::$app->request->post()['Livro']['genero'];
            $formatoProcurado = Yii::$app->request->post()['Livro']['formato'];
        } else {
            $pesquisa = '';
            $generoProcurado = '';
            $formatoProcurado = '';
        }


        //obter todos os generos dos livros existentes
        $generos = $this->obterGenerosLivros();
        $formatos = ['0'=>'Físico', '1'=>'Ebook'];

        $livrosAutor = null;

        //
        if ($generoProcurado != null && $formatoProcurado!=null) {
            //obter os livros de acordo com a pesquisa
            $livros = Livro::find()
                ->where(['like', 'titulo', $pesquisa])
                ->andWhere(['like', 'formato', $formatos[$formatoProcurado]])
                ->andWhere(['like', 'genero', $generos[$generoProcurado]])
                ->all();
        } elseif ($generoProcurado != null){
            //obter os livros de acordo com a pesquisa
            $livros = Livro::find()
                ->where(['like', 'titulo', $pesquisa])
                ->andWhere(['like', 'genero', $generos[$generoProcurado]])
                ->all();
        } elseif ($formatoProcurado != null) {
            //obter os livros de acordo com a pesquisa
            $livros = Livro::find()
                ->where(['like', 'titulo', $pesquisa])
                ->andWhere(['like', 'formato', $formatos[$formatoProcurado]])
                ->all();
        } else {
            $livros = Livro::find()
                ->where(['like', 'titulo', $pesquisa])
                ->all();

            if($pesquisa!=null){
                $autores = Autor::find()
                    ->where(['like', 'nome_autor', $pesquisa]);

                $livrosAutor = Livro::find()
                    ->innerJoin(['sub' => $autores], 'livro.id_autor = sub.id_autor')
                    ->all();
            } else {
                $livrosAutor = null;
            }
        }

        //var_dump($livros, $livrosAutor, $generos);die;
        //return $this->redirect('livro/procurar', array('model' => new Livro(), 'results' => $results));
        return $this->render('index', ['searchModel'=> new Livro(), 'livros'=>$livros, 'livrosAutor'=>$livrosAutor, 'generos'=>$generos]);
    }

    public function actionRequisitado()
    {

        if (Yii::$app->user->can('admin') || Yii::$app->user->can('bibliotecario')) {
            $requisicoes = RequisicaoLivro::find()
                ->orderBy('id_livro')
                ->all();

            $requisicoesTerminadas = [];
            foreach ($requisicoes as $requisicao) {
                if ($requisicao->requisicao->estado == 'Pronta a levantar' || $requisicao->requisicao->estado == 'Em requisição') {
                    array_push($requisicoesTerminadas, $requisicao->id_livro);
                }
            }

            $livros = Livro::find()
                ->where(['id_livro' => $requisicoesTerminadas])
                ->all();

            $livro = new Livro();
            $generos = $this->obterGenerosLivros();

            return $this->render('index', [
                'livros' => $livros,
                'generos' => $generos,
                'livrosAutor' => null,
                'searchModel' => $livro
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Displays a single Livros model.
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
     * Creates a new Livros model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('createLivro')) {
            $model = new Livro();

            $editoras = Editora::find()
                ->orderBy(['id_editora' => SORT_ASC])
                ->all();
            $listEditoras = ArrayHelper::map($editoras, 'id_editora', 'designacao');

            $autores = Autor::find()
                ->orderBy(['id_autor' => SORT_ASC])
                ->all();
            $listAutores = ArrayHelper::map($autores, 'id_autor', 'nome_autor');

            $bibliotecas = Biblioteca::find()
                ->orderBy(['id_biblioteca' => SORT_ASC])
                ->all();
            $listBibliotecas = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

            $modelUpload = new UploadForm();

            if ($model->load(Yii::$app->request->post())) {

                $pasta = 'capas';
                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');

                if ($modelUpload->upload($model['isbn'], $pasta)) {
                    $model->capa = $modelUpload->imageFile->name;
                    $model->save();

                    return $this->redirect(['view', 'id' => $model->id_livro]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ocorreu um erro ao inserir a capa.');
                    return $this->actionCreate();
                }

            }

            return $this->render('create', [
                'model' => $model,
                'editoras' => $listEditoras,
                'autores' => $listAutores,
                'bibliotecas' => $listBibliotecas,
                'modelUpload' => $modelUpload
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Updates an existing Livros model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (Yii::$app->user->can('updateLivro')) {
            $model = $this->findModel($id);

            $editoras = Editora::find()
                ->orderBy(['id_editora' => SORT_ASC])
                ->all();
            $listEditoras = ArrayHelper::map($editoras, 'id_editora', 'designacao');

            $autores = Autor::find()
                ->orderBy(['id_autor' => SORT_ASC])
                ->all();
            $listAutores = ArrayHelper::map($autores, 'id_autor', 'nome_autor');

            $bibliotecas = Biblioteca::find()
                ->orderBy(['id_biblioteca' => SORT_ASC])
                ->all();
            $listBibliotecas = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

            $modelUpload = new UploadForm();

            if ($model->load(Yii::$app->request->post())) {

                $pasta = 'capas';
                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');

                if ($modelUpload->upload($model['isbn'], $pasta)) {
                    $model->capa = $modelUpload->imageFile->name;
                    $model->save();

                    return $this->redirect(['view', 'id' => $model->id_livro]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ocorreu um erro ao inserir a capa.');
                    return $this->actionCreate();
                }

            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_livro]);
            }

            return $this->render('update', [
                'model' => $model,
                'editoras' => $listEditoras,
                'autores' => $listAutores,
                'bibliotecas' => $listBibliotecas,
                'modelUpload' => $modelUpload
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Deletes an existing Livros model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteLivro')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Finds the Livros model based on its primary key value.
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
