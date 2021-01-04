<?php

namespace app\modules\api\controllers;

use app\models\Utilizador;
use common\models\SignupForm;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\HttpException;

class UtilizadorController extends ActiveController
{

    public $modelClass = 'app\models\Utilizador';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = ['class'=>HttpBasicAuth::className(), 'auth'=>[$this, 'authf']];

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
            return 'Leitor Inserido';
        } else {
            $err = json_encode($user->getErrors());
            throw new HttpException(422, $err);
        }
    }

    //procurar utilizador por numero
    public function actionUtilizadorNumero($numero)
    {
        $model = new $this->modelClass;

        $utilizador = $model::find()->where(['numero' => $numero])->one();

        return $utilizador;
    }
}
