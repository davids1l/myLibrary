<?php

use Carbon\Carbon;
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
    <hr>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Requisição', ['site/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'summary' => 'Total de Requisições: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id_requisicao',
                'label' => 'Nº da Requisição',
            ],
            [
                'attribute' => 'dta_levantamento',
                'label' => 'Data de Levantamento',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_levantamento)->format('d-m-Y H:i:s');
                },
            ],
            [
                'attribute' => 'dta_entrega',
                'label' => 'Data de Entrega',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_entrega)->format('d-m-Y H:i:s');
                }
            ],/*
            'estado',
            [
                'attribute' => 'id_utilizador',
                'value' => 'utilizador.user.username',
                'label' => 'Nome de utilizador'
            ],
            [
                'attribute' => 'id_utilizador',
                'value' => 'utilizador.num_telemovel',
                'label' => 'Telemóvel'
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{preparar}',
                'buttons' => [
                    'preparar' => function ($url, $model, $key) {
                        if ($model->estado === "A aguardar tratamento") {
                            return Html::a('Tratar requisição', ['requisicao/preparar', 'id' => $model->id_requisicao], ['class' => 'btn btn-success',
                                'data' => [
                                    'method' => 'post',
                                ]
                            ]);
                        } else if ($model->estado === "Pronta a levantar") {
                            return Html::a('Finalizar requisição', ['requisicao/levantar', 'id' => $model->id_requisicao], ['class' => 'btn btn-success',
                                'data' => [
                                    'method' => 'post',
                                ]
                            ]);
                        } else if ($model->estado === "Em requisição") {
                            return Html::a('Terminar requisição', ['requisicao/terminar', 'id' => $model->id_requisicao], ['class' => 'btn btn-danger',
                                'data' => [
                                    'method' => 'post',
                                ]
                            ]);
                        } else {
                            return Html::label('Terminada');
                        }
                    },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ]
        ],
    ]); ?>


</div>
