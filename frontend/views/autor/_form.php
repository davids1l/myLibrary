<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Autor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="autor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome_autor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_pais')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
