<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class LivroController extends ActiveController
{

    public $modelClass = 'app\models\Livro';

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
        return ['Total de Livros: ' => count($livros),'Livros' => $livros];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
