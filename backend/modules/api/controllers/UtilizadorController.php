<?php

namespace app\modules\api\controllers;

use app\models\Utilizador;
use Carbon\Carbon;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\UploadForm;
use common\models\User;
use Yii;
use yii\bootstrap\Html;
use yii\filters\auth\HttpBasicAuth;
use GuzzleHttp\Psr7\Query;
use yii\rest\ActiveController;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UtilizadorController extends ActiveController
{

    public $modelClass = 'app\models\Utilizador';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = ['class'=>HttpBasicAuth::className(),
            'auth'=>[$this, 'authf'],
            'except' => ['login', 'create-utilizador'],
            ];

        return $behaviors;
    }

    public function authf($email, $password){
        $user = User::findUserByEmail($email);

        if ($user && $user->validatePassword($password)){
            return $user;
        }
    }


    //inserir utilizador
    public function actionCreateUtilizador()
    {
        $utilizador = new \frontend\models\Utilizador();
        $user = new User();

        $utilizador->primeiro_nome = preg_replace('/[^a-z]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", \Yii::$app->request->post('primeiro_nome')));
        $utilizador->ultimo_nome = preg_replace('/[^a-z]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", \Yii::$app->request->post('ultimo_nome')));
        $utilizador->foto_perfil = $utilizador->atribuirImg();

        $user->username = strtolower($utilizador->primeiro_nome) . strtolower($utilizador->ultimo_nome);

        $user->email = \Yii::$app->request->post('email');
        $utilizadores = $user::find()->where(['email' => $user->email])->one();
        if ($utilizadores != null) {
            throw new HttpException(422, 'Esse email já se encontra em utilização.');
        }

        $user->setPassword(\Yii::$app->request->post('password'));
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10;

        $utilizador->numero = $utilizador->gerarNumeroLeitor();

        $utilizador->dta_nascimento = \Yii::$app->request->post('dta_nascimento');
        if ($utilizador->validarDataNascimento() == false) {
            throw new HttpException(422, 'Data de nascimento inválida.');
        }

        $utilizador->nif = \Yii::$app->request->post('nif');
        $utilizadores = $utilizador::find()->where(['nif' => $utilizador->nif])->one();
        if ($utilizadores != null) {
            throw new HttpException(422, 'Esse NIF já se encontra em utilização.');
        }

        $utilizador->num_telemovel = \Yii::$app->request->post('num_telemovel');
        if ($utilizador->validarNumTelemovel() == false) {
            throw new HttpException(422, 'Número de telemóvel inválido. Insira um número que comece por 9.');
        }

        $user->save();
        $utilizador->id_utilizador = $user->getId();
        $utilizador->save();
        $utilizador->atribuirRoleLeitor();


        $user->username = $user->username . '_' . $utilizador->numero;
        $result = $user->save();

        if ($result) {
            return ['success' => true, 'result' => 'ok'];
        } else {
            $err = json_encode($user->getErrors());
            throw new HttpException(422, $err);
        }
    }

    //procurar utilizador por numero
    public function actionUtilizadorNumero($numero)
    {
        $model = new $this->modelClass;

        $subQuery = (new \yii\db\Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
        $utilizador = $model::find()->where(['id_utilizador' => $subQuery, 'numero' => $numero])->one();

        if($utilizador == null){
            throw new NotFoundHttpException('Leitor com o número ' . $numero . ' não encontrado.');
        }

        return $utilizador;
    }

    //leitores bloqueados
    public function actionBloqueados(){
        $model = new $this->modelClass;

        $subQuery = (new \yii\db\Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
        $utilizadores = $model::find()->where(['id_utilizador' => $subQuery, 'bloqueado' => !null])->all();

        return ['Existem ' . count($utilizadores) . ' leitores   bloqueados.', $utilizadores];
    }

    //login
    public function actionLogin(){
        $login = new LoginForm();

        $email = \Yii::$app->request->post('email');
        $password = \Yii::$app->request->post('password');

        $user = User::findUserByEmail($email);

        if($user == null){
            return 'Email incorreto.';
        }

        $utilizador = Utilizador::find()->where(['id_utilizador' => $user->id])->one();


        if($user->validatePassword($password)){
            $login->login();
            return ['success' => true, 'token' => "Basic " . base64_encode($email . ":" .$password), 'id' => $user->id, 'bloqueado' => $utilizador->bloqueado];
        }else{
            return 'Palavra-passe incorreta. Tente novamente.';
        }
    }


    public function actionEditar($id){

        $utilizador = Utilizador::find()->where(['id_utilizador' => $id])->one();
        $user = User::find()->where(['id' => $id])->one();

        $utilizador->primeiro_nome = Yii::$app->request->post('primeiro_nome');
        $utilizador->ultimo_nome = Yii::$app->request->post('ultimo_nome');
        $utilizador->num_telemovel = Yii::$app->request->post('num_telemovel');
        $utilizador->dta_nascimento = Yii::$app->request->post('dta_nascimento');
        $utilizador->nif = Yii::$app->request->post('nif');

        $user->email = Yii::$app->request->post('email');

        $utilizador->save();
        $user->save();

        return [$utilizador, 'email' => $user->email];

    }


    public function actionLeitor($id){
        $utilizador = Utilizador::find()->where(['id_utilizador' => $id])->one();
        $user = User::find()->where(['id' => $id])->one();

        return ['utilizador' => $utilizador, 'email' => $user->email];
    }

    public function actionDadosUtilizadores() {

        $utilizadores = Utilizador::find();

        $users = (new \yii\db\Query())
            ->select(['*'])
            ->from('user')
            ->innerJoin(['sub' => $utilizadores], 'user.id = sub.id_utilizador')
            ->all();

        return $users;

    }



    public function actionUpload($id){

        $utilizador = Utilizador::find()->where(['id_utilizador' => $id])->one();
        $min = 1;
        $max = 999;

        $numero = rand($min, $max);

        $output_file = '../../frontend/web/imgs/perfil/' . $utilizador->numero . '_' . $numero . '.png';

        $dados = Yii::$app->request->post('foto_perfil');


        $file = fopen($output_file, 'wb');
        fwrite($file, base64_decode($dados));
        fclose($file);

        if($utilizador->foto_perfil != 'userImg.png'){
            unlink('../../frontend/web/imgs/perfil/' . $utilizador->foto_perfil);
        }

        $utilizador->foto_perfil = $utilizador->numero . '_' . $numero . '.png';
        $utilizador->save();
        return $utilizador;
    }
}
