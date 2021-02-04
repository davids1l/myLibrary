<?php
namespace backend\controllers;

use app\models\Livro;
use app\models\Requisicao;
use app\models\RequisicaoLivro;
use app\models\RequisicaoSearch;
use app\models\Utilizador;
use app\models\UtilizadorSearch;
use Carbon\Carbon;
use common\models\LoginFormBackend;
use frontend\models\Multa;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'error','logout', 'index', 'preparar', 'levantar', 'addUser', 'delete'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['login', 'error','logout', 'index', 'preparar', 'levantar', 'addUser', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequisicaoSearch();
        $user = new Utilizador();
        $dataProviderTratar = $searchModel->searchFiltered(Yii::$app->request->queryParams, 1);
        $dataProviderEntregar = $searchModel->searchFiltered(Yii::$app->request->queryParams, 2);
        $dataProviderTerminar = $searchModel->searchFiltered(Yii::$app->request->queryParams, 3);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchModelCriarReq' => $user,
            'dataProviderTratar' => $dataProviderTratar,
            'dataProviderEntregar' => $dataProviderEntregar,
            'dataProviderTerminar' => $dataProviderTerminar
        ]);
    }

    public function actionAddUser() {
        $user = new Utilizador();
        $session = Yii::$app->session;

        if (Yii::$app->request->post('Utilizador')['numero'] != null) {
            $searchModel = new UtilizadorSearch();
            $utilizador = $searchModel->procurar(Yii::$app->request->post('Utilizador')['numero']);

            $session->open();
            $_SESSION['dadosUser'] = $utilizador;
            $session->close();
        }else if (Yii::$app->request->post()) {
            return $this->redirect(['requisicao/create']);
        }

        return $this->redirect('index');
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

                return $this->redirect(['site/index']);
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

    public function actionLivro($id) {
        $reqLivro = RequisicaoLivro::find()->where(['id_requisicao' => $id])->all();

        foreach($reqLivro as $rl) {
            $livros[] = Livro::find()->where(['id_livro' => $rl->id_livro])->all();
        }

        return $this->render('/requisicao/livro', [
            'livros' => $livros,
            'requisicao' => $id
        ]);
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

                return $this->redirect(['site/index']);
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

    public function actionTerminar()
    {
        if (Yii::$app->user->can('updateRequisicao')) {
            $searchModel = new RequisicaoSearch();
            $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, 3);

            if (Yii::$app->request->queryParams) {
                $id = Yii::$app->request->queryParams['id'];
                $model = $this->findModel($id);

                //função para validar se exite multa de acordo com a data de entrega e atual, se sim é criada uma multa
                $this->createMulta($model);

                $model->dta_entrega = Carbon::now()->format("Y-m-d\TH:i");
                $model->estado = "Terminada";
                $model->save();

                return $this->redirect(['site/index']);
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

    protected function findModel($id)
    {
        if (($model = Requisicao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //$this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if(Yii::$app->user->can('bibliotecario') || Yii::$app->user->can('admin')){
                return $this->goBack();
            }else{
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Não tem permissões para aceder.');
                $model->password = '';
                $model->email = '';
                return $this->render('login', ['model' => $model]);
            }
        } else {

            $model->password = '';
            return $this->render('login', ['model' => $model]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
