<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequisicaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requisições';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Requisição', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Requisição p/ preparar', ['preparar'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Requisição pronta a Levantar', ['levantar'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar Todas', ['index'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_requisicao',
            'dta_levantamento',
            'dta_entrega',
            'estado',
            'id_utilizador',
            //'id_bib_levantamento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
