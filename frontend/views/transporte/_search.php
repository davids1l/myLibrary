<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransporteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transporte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_transporte') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'id_bib_despacho') ?>

    <?= $form->field($model, 'id_bib_recetora') ?>

    <?= $form->field($model, 'dta_despacho') ?>

    <?php // echo $form->field($model, 'dta_recebida') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
