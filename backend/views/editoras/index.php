<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EditoraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Editoras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editora-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Editora', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'summary' => 'Total de Editoras: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_editora',
            [
                'attribute' => 'designacao',
                'label' => 'Designação'
            ],
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
                                'confirm' => 'Tem a certeza que quer eliminar a editora ' . $model->designacao . '?',
                                'method' => 'post',
                            ]
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
