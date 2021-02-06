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

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>
    <?= Html::a('<span class="glyphicon glyphicon-plus" style="margin-bottom: 30px; margin-top: 10px"></span> Adicionar Autor', ['create'], ['class' => 'btnAcao']) ?>


    <?= GridView::widget([
        'summary' => 'Total de Autores: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'nome_autor',
                'label' => 'Nome do Autor'
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
