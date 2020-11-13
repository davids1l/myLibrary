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

    <p>
        <?= Html::a('Create Editora', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_editora',
            'designacao',
            'id_pais',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
