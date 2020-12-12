<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Utilizador */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utilizador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_utilizador')->textInput() ?>

    <?= $form->field($model, 'primeiro_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ultimo_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bloqueado')->textInput() ?>

    <?= $form->field($model, 'dta_bloqueado')->textInput() ?>

    <?= $form->field($model, 'dta_nascimento')->textInput() ?>

    <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_telemovel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dta_registo')->textInput() ?>

    <?= $form->field($model, 'foto_perfil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_biblioteca')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
