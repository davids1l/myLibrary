<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BibliotecaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bibliotecas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <button class="buttonPanel"><?= Html::a('Adicionar biblioteca', ['bibliotecas/create']); ?></button>
    <br/>
    <?php if($bibliotecas != null) { ?>
        <?php foreach ($bibliotecas as $biblioteca) { ?>
            <div class="col-xs-12 col-md-4">
                <h4><?= Html::encode($biblioteca->nome)?> (ID: <?= Html::encode($biblioteca->id_biblioteca)?>)</h4>
                <h6>Código postal: <?= Html::encode($biblioteca->cod_postal)?></h6>

                <?= Html::a('View', ['bibliotecas/view', 'id' => $biblioteca->id_biblioteca])?>
                <?= Html::a('Update', ['update', 'id' => $biblioteca->id_biblioteca], [
                    'style' => 'color: green'
                ]) ?>
                <?= Html::a('Delete', ['delete', 'id' => $biblioteca->id_biblioteca], [
                    'style' => 'color: red',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Catálogo', ['bibliotecas/catalogo', 'id' => $biblioteca->id_biblioteca])?>
            </div>
        <?php }
    } else { ?>
        <br/>
        <p>Parece que não foram encontradas bibliotecas no sistema.</p>
    <?php } ?>

    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_biblioteca',
            'nome',
            'cod_postal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>


</div>
