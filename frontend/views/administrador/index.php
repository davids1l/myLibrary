<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdministradorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administradors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrador-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Administrador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_admin',
            'num_admin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
