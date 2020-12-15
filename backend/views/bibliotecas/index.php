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

    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar biblioteca', ['bibliotecas/create'], [
            'class' => 'btn btn-success'
    ]); ?>
    <br/>
    <div class="row rowStyling">
    <?php if($bibliotecas != null) { ?>
        <?php foreach ($bibliotecas as $biblioteca) { ?>
            <div class="col-xs-12 col-md-6 listaBiblioteca">
                <h4><?= Html::encode($biblioteca->nome)?> (ID: <?= Html::encode($biblioteca->id_biblioteca)?>)</h4>
                <h6>Código postal: <?= Html::encode($biblioteca->cod_postal)?></h6>

                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> Detalhes', ['bibliotecas/view', 'id' => $biblioteca->id_biblioteca], [
                    'class' => 'btn btn-primary'
                ])?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $biblioteca->id_biblioteca], [
                    'class' => 'btn btn-success'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $biblioteca->id_biblioteca], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Catálogo', ['bibliotecas/catalogo', 'id' => $biblioteca->id_biblioteca], [
                    'class' => 'btn btn-info'
                ])?>

            </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    </div>
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
