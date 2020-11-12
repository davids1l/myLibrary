<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Leitor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leitor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'num_leitor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bloqueado')->textInput() ?>

    <?= $form->field($model, 'dta_bloqueado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
