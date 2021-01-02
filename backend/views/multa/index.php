<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MultaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Multas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multa-index">

    <h1><?= Html::encode($this->title).' em dívida' ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Total de multas: {totalCount}',
        'columns' => [

            'id_multa',
            'montante',
            'estado',
            'id_requisicao',
            'dta_multa',

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'template' => '{multa}',
                'buttons' => [
                    'multa' => function ($key, $model) {
                        if($model->estado == 'Pago'){
                            return Html::a('Validar pagamento', null,
                                ['class' => 'btn btn-success disabled', 'style' => 'cursor: not-allowed;']);
                        } else {
                            return Html::a('Validar pagamento', ['multa/update', 'id' => $model->id_multa],
                                ['data' => ['method' => 'post', 'confirm' =>'Deseja validar o pagamento?'], 'class' => 'btn btn-success', 'style' => 'cursor: pointer']);
                        }
                    }
                ]
            ],
        ],
    ]); ?>


</div>
