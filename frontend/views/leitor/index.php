<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LeitorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leitors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leitor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leitor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_leitor',
            'num_leitor',
            'bloqueado',
            'dta_bloqueado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
