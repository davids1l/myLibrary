<?php


namespace app\modules\api\controllers;


use app\models\Requisicao;
use yii\rest\ActiveController;

class BibliotecaController extends ActiveController
{
    public $modelClass = 'app\models\Biblioteca';

    //devolve as bibliotecas cujo código postal contenha o valor procurado
    public function actionCodigopostal($cod_postal){
        $model = new $this->modelClass;

        if(strlen($cod_postal) > 7){
            return 'Código postal inválido';
        }

        if(strlen($cod_postal) <= 4){
            $bibliotecas = $model::find()
                ->where(['like', 'cod_postal',  $cod_postal])
                ->all();
        }else{
            $inicio = substr($cod_postal, 0,4);
            $fim = substr($cod_postal, 4, 3);
            $cod_postal = $inicio . '-' . $fim;

            $bibliotecas = $model::find()
                ->where(['like', 'cod_postal',  $cod_postal])
                ->all();
        }

        if($bibliotecas == null){
            return 'Não existem bibliotecas inseridas com o código postal ' . $cod_postal;
        }

        return ['bibliotecas'=>$bibliotecas];
    }

    //devolve o total de bibliotecas no sistema
    public function actionTotalbibliotecas(){
        $model = new $this->modelClass;
        $total = $model->find()->all();
        return ['Total de bibliotecas' => count($total)];
    }

    //devolve apenas o nome da biblioteca de acordo com id fornecido
    public function actionNome($id){
        $model = new $this->modelClass;
        $nomeBib = $model->find()
            ->where('id_biblioteca='.$id)
            ->one();
        if($nomeBib){
            return ['id'=>$id, 'nome'=>$nomeBib->nome];
        }
        //return ['id'=>$id, 'nome'=>null];
        return ['Biblioteca com id='.$id.' não encontrada.'];
    }

}