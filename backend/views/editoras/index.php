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

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>
    <?= Html::a('<span class="glyphicon glyphicon-plus" style="margin-bottom: 30px; margin-top: 10px"></span> Inserir Editora', ['create'], ['class' => 'btnAcao']) ?>


    <?= GridView::widget([
        'summary' => 'Total de Editoras: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'designacao',
                'label' => 'Nome da Editora'
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
