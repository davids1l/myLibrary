<?php

namespace app\controllers;

namespace backend\controllers;

use frontend\models\Multa;
use app\models\Biblioteca;
use app\models\Livro;
use app\models\LivroSearch;
use app\models\RequisicaoLivro;
use app\models\Utilizador;
use Carbon\Carbon;
use common\models\User;
use Yii;
use app\models\Requisicao;
use app\models\RequisicaoSearch;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequisicaoController implements the CRUD actions for Requisicao model.
 */
class RequisicaoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'preparar', 'levantar', 'terminar', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'preparar', 'levantar', 'terminar', 'create', 'update', 'delete'],
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
     * Lists all Requisicao models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('bibliotecario')) {
            $searchModel = new RequisicaoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para aceder a essa página.');
            return $this->redirect(['site/index']);
        }
    }

    public function actionPreparar()
    {
        if (Yii::$app->user->can('updateRequisicao')) {
            $searchModel = new RequisicaoSearch();
            $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, 1);

            if (Yii::$app->request->queryParams) {
                $id = Yii::$app->request->queryParams['id'];
                $model = $this->findModel($id);

                $model->estado = "Pronta a levantar";
                $model->save();

                return $this->redirect(['requisicao/index']);
            }

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    public function actionLevantar()
    {
        if (Yii::$app->user->can('updateRequisicao')) {
            $searchModel = new RequisicaoSearch();
            $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, 2);

            if (Yii::$app->request->queryParams) {
                $id = Yii::$app->request->queryParams['id'];
                $model = $this->findModel($id);

                $model->dta_levantamento = Carbon::now()->format("Y-m-d\TH:i");
                $model->dta_entrega = Carbon::now()->addDays("30")->format("Y-m-d\TH:i");
                $model->estado = "Em requisição";
                $model->save();

                return $this->redirect(['requisicao/index']);
            }

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    public function createMulta($requisicaoModel)
    {
        //converter de string para data
        $dataEntrega = Carbon::parse($requisicaoModel->dta_entrega)->toDateTime();

        //verifica se a data de de entrega é inferior á data atual, se sim então foi excedido o prazo de entrega
        //Carbon::parse($requisicaoModel->dta_entrega)->lessThan(Carbon::now());
        //$dataEntrega < Carbon::now()
        if ($dataEntrega < Carbon::now()) {

            //obtem a diferença entre as datas de entrega e atual
            $dateDiff = date_diff($dataEntrega, Carbon::now());

            //somar o montante da multa (para cada dia de atraso a multa acresce 0.50€)
            $multaMontante = 0.50 * $dateDiff->days;

            //parametros a inserir
            $multaModel = new Multa();

            $multaModel->montante = $multaMontante;
            $multaModel->estado = "Em dívida";
            $multaModel->dta_multa = Carbon::now();
            $multaModel->id_requisicao = $requisicaoModel->id_requisicao;

            //criar multa
            $multaModel->validate() ? $multaModel->save() : null;
        }

    }

    public function actionTerminar($id)
    {
        if (Yii::$app->user->can('updateRequisicao')) {
            $searchModel = new RequisicaoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $model = $this->findModel($id);

            //função para validar se exite multa de acordo com a data de entrega e atual, se sim é criada uma multa
            $this->createMulta($model);

            $model->dta_entrega = Carbon::now()->format("Y-m-d\TH:i");
            $model->estado = "Terminada";
            $model->save();

            $this->redirect(['requisicao/index']);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Displays a single Requisicao model.
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
     * Creates a new Requisicao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // Modelo e lista de livros a passar para a vista
        $livro = new Livro();

        $subQuery = (new Query())->select('id_livro')->from('requisicao_livro');
        $livrosReq = Livro::find()
            ->where(['id_livro' => $subQuery])
            ->orderBy(['titulo' => SORT_ASC])
            ->all();

        $livros = Livro::find()
            ->orderBy(['titulo' => SORT_ASC])
            ->all();

        // Dados para popular menus dropdown.
        $subQueryRole = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
        $utilizadores = Utilizador::find()
            ->where(['id_utilizador' => $subQueryRole])
            ->orderBy('id_utilizador')
            ->all();
        $listUtilizadores = ArrayHelper::map($utilizadores, 'id_utilizador', 'num_telemovel');

        $bibliotecas = Biblioteca::find()
            ->orderBy(['id_biblioteca' => SORT_ASC])
            ->all();
        $listBibliotecas = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');

        // Requisição
        $carrinho = Yii::$app->session->get('carrinho');
        $postData = Yii::$app->request->post();

        $model = new Requisicao();
        $modelReqLivro = new RequisicaoLivro();

        $model->dta_levantamento = Carbon::now()->format("Y-m-d\TH:i");
        $model->dta_entrega = Carbon::now()->addDays("30")->format("Y-m-d\TH:i");
        $model->estado = "Em requisição";

        if ($model->load(Yii::$app->request->post()))
            $model->id_bib_levantamento = $postData['Requisicao']['id_bib_levantamento'];

        if ($carrinho != null) {
            $total_livros = $this->totalLivrosEmRequisicao() + count($carrinho);
            $num_excluir = (($total_livros) - 5);

            if ($total_livros <= 5) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {

                    $this->adicionarRequisicaoLivro($model->id_requisicao, $carrinho);

                    Yii::$app->session->destroy();
                    Yii::$app->session->setFlash('success', 'Obrigado pela sua requisição!');

                    return $this->redirect(['view', 'id' => $model->id_requisicao]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Excedeu o limite de 5 livros em requisição. Por favor, exclua ' . $num_excluir . ' livro para concluir esta requisição.');
                return $this->redirect(['requisicao/create']);
            }
        } else if ($model->load(Yii::$app->request->post()) && $carrinho == null) {
            Yii::$app->session->setFlash('error', 'Ocorreu um problema ao finalizar a sua requisição! Tente novamente.');
        }

        if (Yii::$app->request->post('Livro')['titulo'] != null) {
            $searchModel = new LivroSearch();
            $livros = $searchModel->procurar(Yii::$app->request->post('Livro')['titulo']);
        }

        return $this->render('create', [
            'model' => $model,
            'utilizadores' => $listUtilizadores,
            'bibliotecas' => $listBibliotecas,
            'livros' => $livros,
            'livrosReq' => $livrosReq,
            'searchModel' => $livro
        ]);
    }

    /**
     * Updates an existing Requisicao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('updateRequisicao')) {
            $model = $this->findModel($id);

            $subQueryRole = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
            $users = User::find()
                ->where(['id' => $subQueryRole])
                ->orderBy(['id' => SORT_ASC])
                ->all();

            $listUsers = ArrayHelper::map($users, 'id', 'username');

            $bibliotecas = Biblioteca::find()
                ->orderBy(['id_biblioteca' => SORT_ASC])
                ->all();
            $listBibliotecas = ArrayHelper::map($bibliotecas, 'id_biblioteca', 'nome');


            $dtaLevantamento = new Carbon($model->dta_levantamento);
            $dtaEntrega = new Carbon($model->dta_entrega);

            $model->dta_levantamento = $dtaLevantamento->format("Y-m-d\TH:i");
            $model->dta_entrega = $dtaEntrega->format("Y-m-d\TH:i");

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_requisicao]);
            }

            return $this->render('update', [
                'model' => $model,
                'users' => $listUsers,
                'bibliotecas' => $listBibliotecas
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Deletes an existing Requisicao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteRequisicao')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para fazer essa ação.');
            return $this->redirect(['site/index']);
        }
    }

    public function adicionarRequisicaoLivro($id_requisicao, $carrinho)
    {
        $requisicaoModel = new RequisicaoLivro();

        /*
         * Insere dados na tabela requisicao_livro com recurso à estrutura Yii DAO(Database Access Objects)
         * recomendado quando o objetivo é inserir multiplos objetos
         */
        foreach ($carrinho as $livro) {
            try {
                Yii::$app->db->createCommand()->insert('requisicao_livro', [
                    'id_livro' => $livro->id_livro,
                    'id_requisicao' => $id_requisicao,
                ])->execute();
            } catch (Exception $e) {
            }
        }
    }

    /**
     * Através do id do utilizador com login efetuado determina a quantidade de livros que este tem em requisição
     * Se este nº exceder um total de 5, então o utilizador atingiu o limite de livros em requisição e é negado adicionar este ao carrinho/finalizar requisicao
     */
    public function totalLivrosEmRequisicao()
    {
        //subquery que obtem os dados relativos à requisicao em que se verifique => id utilizador = id utilizador logado e estado da requisicao terminada
        $subQuery = Requisicao::find()
            ->where(['id_utilizador' => Yii::$app->user->id])
            ->andWhere(['!=', 'estado', 'Terminada']);

        //query responsável por obter a contagem de "requisicao_livro" onde se verfique subquery.id_requisicao = requiscao_livro.id_requisicao
        $totalReq = RequisicaoLivro::find()
            ->innerJoin(['sub' => $subQuery], 'requisicao_livro.id_requisicao = sub.id_requisicao')
            ->count();

        return $totalReq;
    }

    /**
     * Finds the Requisicao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Requisicao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requisicao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
