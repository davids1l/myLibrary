<?php


namespace app\modules\api\controllers;


use yii\rest\ActiveController;

class BibliotecaController extends ActiveController
{
    public $modelClass = 'app\models\Biblioteca';

    //devolve as bibliotecas cujo código postal contenha o valor procurado
    public function actionCodigopostal($cod_postal){
        $model = new $this->modelClass;
        $bibliotecas = $model::find()
            ->where(['like', 'cod_postal',  $cod_postal])
            ->all();

        return ['bibliotecas'=>$bibliotecas];
    }

    //devolve o total de bibliotecas no sistema
    public function actionTotalbibliotecas(){
        $model = new $this->modelClass;
        $total = $model->find()->all();
        return ['total' => count($total)];
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