<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transporte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transporte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_bib_despacho')->textInput() ?>

    <?= $form->field($model, 'id_bib_recetora')->textInput() ?>

    <?= $form->field($model, 'dta_despacho')->textInput() ?>

    <?= $form->field($model, 'dta_recebida')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
