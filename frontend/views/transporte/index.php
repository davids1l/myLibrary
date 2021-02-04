<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransporteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transportes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transporte-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Transporte', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_transporte',
            'estado',
            'id_bib_despacho',
            'id_bib_recetora',
            'dta_despacho',
            //'dta_recebida',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
