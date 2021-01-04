<?php

namespace app\modules\api\controllers;

use app\models\RequisicaoLivro;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class LivroController extends ActiveController
{
    public $modelClass = 'app\models\Livro';

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

    //devolve o total de livros
    public function actionTotal(){
        $model = new $this->modelClass;
        $total = $model::find()->all();
        return ['total' => count($total)];
    }

    //apaga todos os livros existentes na BD
    public function actionDeleteAll(){
        $model = new $this->modelClass;
        $resp = $model->deleteAll();

        if($resp) {
            \Yii::$app->response->statusCode = 200;
            return 'Todos os livros foram apagados.';
        }
        \Yii::$app->response->statusCode = 404;
        return 'Ocorreu um erro ao apagar todos os livros.';
    }

    //devolve o total de livros e os livros que são do ano inserido
    public function actionAno($ano){
        $model = new $this->modelClass;
        $livros = $model::find()->where(['ano' => $ano])->all();
        if($livros == null){
            return 'Não existem livros desse ano.';
        }
        return ['Total de Livros de  ' . $ano . ':' => count($livros),'Livros' => $livros];
    }

    /*public function actionMaisRequisitados(){
        $model = new $this->modelClass;
        $livros = $model::find()->all();
        $requisicoes = RequisicaoLivro::find()->all();

        $primeiro = array(0,null);
        $segundo = array(0,null);
        $terceiro= array(0,null);

        foreach ($livros as $livro){
            $contador = 0;
            foreach ($requisicoes as $requisicao){
                if($requisicao->id_livro == $livro->id_livro){
                    $contador++;
                }
            }
        }

        return [$primeiro, $segundo, $terceiro];
    }*/


}
