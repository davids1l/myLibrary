<?php

namespace frontend\controllers;

use app\models\Leitor;
use app\models\Livro;
use app\models\Requisicao;
use app\models\RequisicaoLivro;
use common\models\FormularioLogin;
use common\models\SignupForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\Utilizador;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
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

    /**
     * @return array
     * Função responsável por obter os 6 livros com o maior número de favoritos
     *
     */
    public function livrosComMaisFavoritos(){
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($modelLogin = null)
    {
        if($modelLogin == null){
            $modelLogin = new LoginForm();
        }

        $model = new SignupForm();

        $modelLivro = new Livro();
        $recentes = $this->livrosRecentesFilter();
        $maisRequisitados = $this->livrosMaisRequisitados();
        $maisFavoritos = $this->livrosComMaisFavoritos();

        return $this->render('index', ['modelLogin' => $modelLogin, 'model' => $model, 'modelLivro' => $modelLivro, 'maisRequisitados' => $maisRequisitados, 'recentes' => $recentes, 'maisFavoritos' => $maisFavoritos]);
    }


    function actionShowmodal($modelLogin = null, $model = null){
        if($modelLogin == null){
            $modelLogin = new LoginForm();
        }
        if($model == null){
            $model = new SignupForm();
        }

        $modelLivro = new Livro();
        $recentes = $this->livrosRecentesFilter();
        $maisRequisitados = $this->livrosMaisRequisitados();
        $maisFavoritos = $this->livrosComMaisFavoritos();

        $js='$("#regLogModal").modal("show")';
        $this->getView()->registerJs($js);
        return $this->render('index', ['modelLogin' => $modelLogin, 'model' => $model, 'modelLivro' => $modelLivro, 'maisRequisitados' => $maisRequisitados, 'recentes' => $recentes, 'maisFavoritos' => $maisFavoritos]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $utilizador = Utilizador::find()->where(['id_utilizador' => $model->User->id])->one();

            if($utilizador->bloqueado != null){
                Yii::$app->user->logout();
                $model->password = '';
                Yii::$app->session->setFlash('error', 'A conta a que está a tentar aceder encontra-se bloqueada.');
                return $this->actionIndex($model);
            }else{
                return $this->goBack();
            }

        } else {
            $model->password = '';
            return $this->render('login', ['model' => $model]);
            //return $this->actionShowmodal($model);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $user = new SignupForm();
        if ($user->load(Yii::$app->request->post()) && $user->signup(0)) {
            Yii::$app->session->setFlash('success', 'Obrigado pelo seu registo.');
            return $this->goHome();
        }

        $user->password = '';
        $user->confirmarPassword = '';
        return $this->render('signup', ['model' => $user]);
        //return $this->actionShowmodal(null, $user);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

}
