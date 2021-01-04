<?php

namespace app\modules\api\controllers;


use Carbon\Carbon;
use common\models\User;
use yii\db\Query;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class RequisicaoController extends ActiveController
{

    public $modelClass = 'app\models\Requisicao';

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

    //procurar requisições por estado
    public function actionProcurarEstado($estado){
        $model = new $this->modelClass;

        switch ($estado){
            case 1:
                $requisicoes = $model::find()->where(['estado' => 'A aguardar tratamento'])->all();
                $estado = 'A aguardar tratamento';
                break;
            case 2:
                $requisicoes = $model::find()->where(['estado' => 'Pronta a levantar'])->all();
                $estado = 'Pronta a levantar';
                break;
            case 3:
                $requisicoes = $model::find()->where(['estado' => 'Em requisição'])->all();
                $estado = 'Em requisição';
                break;
            case 4:
                $requisicoes = $model::find()->where(['estado' => 'Terminada'])->all();
                $estado = 'Terminada';
                break;
            default: return 'O estado inserido é inválido. Insira um estado entre 1 e 4 inclusive';
        }
        $quant = count($requisicoes);

        if($quant == 0){
            return 'Não existem requisições com o estado \'' . $estado . '\'';
        }
        return ['Existem ' . $quant . ' requisições com o estado \'' . $estado . '\'' , 'Requisições:' => $requisicoes];
    }


    //utilizadores com mais requisições
    public function actionUtilizadoresMaisRequisicoes(){
        $model = new $this->modelClass;

        $top = $model::find()->asArray()
            ->select(['id_utilizador', 'COUNT(*) AS "Nº de livros requisitados"'])
            ->groupBy('id_utilizador')
            ->orderBy(['Nº de livros requisitados' => SORT_DESC])
            ->limit(3)
            ->all();

        return $top;
    }

    //nr de requisições por cada biblioteca
    public function actionRequisicoesBiblioteca(){
        $model = new $this->modelClass;

        $top = $model::find()->asArray()
            ->select(['id_bib_levantamento', 'COUNT(*) AS "Nº de requisições"'])
            ->groupBy('id_bib_levantamento')
            ->orderBy(['Nº de requisições' => SORT_DESC])
            ->all();

        return $top;
    }

    //tempo restante por requesições que ainda não foram entregues
    public function actionTempoRestante(){
        $model = new $this->modelClass;
        $carbon = new Carbon();

        $requisicoes = $model::find()->where(['estado' => 'Em requisição'])->orderBy(['dta_entrega' => SORT_ASC])->all();
        if($requisicoes == null){
            return 'Não existem requisições a decorrer de momento';
        }

        $i = 0;
        foreach ($requisicoes as $requisicao){
            $tempoRestante[$i][0] = 'ID da requisição: ' . $requisicao->id_requisicao;
            $tempoRestante[$i][1] = 'ID do utilizador: ' . $requisicao->id_utilizador;

            if($requisicao->dta_entrega > $carbon::now()){
                $horas = $carbon::now()->diffInHours($requisicao->dta_entrega);
                $dias = intdiv($horas,24);
                $restoHoras = $horas%24;

                $tempoRestante[$i][2] = 'Tempo restante: ' . $dias . ' dias e ' . $restoHoras . ' horas para terminar o prazo de entrega.';
            }else{
                $tempoRestante[$i][2] = 'Entrega atrasada.';
            }
            $i++;
        }
        return $tempoRestante;
    }

}
