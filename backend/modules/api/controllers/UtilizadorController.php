<?php

namespace app\modules\api\controllers;

use app\models\Utilizador;
use common\models\SignupForm;
use common\models\User;
use GuzzleHttp\Psr7\Query;
use yii\rest\ActiveController;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class UtilizadorController extends ActiveController
{

    public $modelClass = 'app\models\Utilizador';

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

        return ['Existem ' . count($utilizadores) . ' leitores bloqueados.', $utilizadores];
    }
}
