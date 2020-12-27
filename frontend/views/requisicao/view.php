<?php

use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Requisição #' . $model->id_requisicao;
//$this->params['breadcrumbs'][] = ['label' => 'Requisicaos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="requisicao-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php
    $livros = RequisicaoLivro::find()->where(['id_requisicao' => $model->id_requisicao])->all();
    foreach ($livros as $livro) {
        $detalhes = Livro::find()->where(['id_livro' => $livro->id_livro])->one();
        echo DetailView::widget([
            'model' => $detalhes,
            'attributes' => [
                [
                    'label' => 'Título',
                    'value' => function ($detalhes) {
                            return $detalhes->titulo;
                    }
                ],
                [
                    'label' => 'Capa',
                    'format' => 'html',
                    'value' => function ($detalhes) {
                            return Html::img($detalhes->capa, ['width' => '100px']);
                    }
                ],
            ]
        ]);
    }
    ?>

</div>
