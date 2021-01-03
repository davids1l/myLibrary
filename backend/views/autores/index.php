<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AutorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Autor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'summary' => 'Total de Autores: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_autor',
            'nome_autor',
            [
                'attribute' => 'id_pais',
                'value' => 'pais.designacao',
                'label' => 'País'
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'data' => [
                                'confirm' => 'Tem a certeza que quer eliminar o autor(a) ' . $model->nome_autor . '?',
                                'method' => 'post',
                            ]
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
