<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UtilizadorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bibliotecários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizador-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Utilizador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_utilizador',
            'primeiro_nome',
            'ultimo_nome',
            'numero',
            'bloqueado',
            //'dta_bloqueado',
            //'dta_nascimento',
            //'nif',
            //'num_telemovel',
            //'dta_registo',
            //'foto_perfil',
            //'id_biblioteca',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
