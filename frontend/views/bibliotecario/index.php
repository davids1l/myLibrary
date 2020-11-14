<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BibliotecarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bibliotecarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bibliotecario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bibliotecario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_bibliotecario',
            'num_bibliotecario',
            'id_biblioteca',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
