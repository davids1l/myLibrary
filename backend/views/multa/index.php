<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MultaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Multas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multa-index">

    <h1 class="topicos"><?= Html::encode($this->title).' em dívida' ?></h1>
    <hr>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Total de multas: {totalCount}',
        'columns' => [

            'montante',
            'estado',
            [
                'attribute' => 'id_requisicao',
                'label' => 'Nº da Requisição',
            ],

            [
                'attribute' => 'dta_multa',
                'label' => 'Data da Multa',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_multa)->format('d-m-Y H:i:s');
                }
            ],


            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'template' => '{multa}',
                'buttons' => [
                    'multa' => function ($key, $model) {
                        if($model->estado == 'Pago'){
                            return Html::a('<i class="fas fa-check"></i> Pago', null,
                                ['class' => 'btnAcaoDisabled disabled', 'style' => 'cursor: not-allowed;']);
                        } else {
                            return Html::a('Validar pagamento', ['multa/update', 'id' => $model->id_multa],
                                ['data' => ['method' => 'post', 'confirm' =>'Deseja validar o pagamento?'], 'class' => 'btnAcao', 'style' => 'cursor: pointer']);
                        }
                    }
                ]
            ],
        ],
    ]); ?>


</div>
