<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bibliotecario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bibliotecario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'num_bibliotecario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_biblioteca')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
