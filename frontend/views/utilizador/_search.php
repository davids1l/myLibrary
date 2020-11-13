<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UtilizadorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utilizador-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_utilizador') ?>

    <?= $form->field($model, 'primeiro_nome') ?>

    <?= $form->field($model, 'ultimo_nome') ?>

    <?= $form->field($model, 'dta_nacimento') ?>

    <?= $form->field($model, 'nif') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'dta_registo') ?>

    <?php // echo $form->field($model, 'foto_perfil') ?>

    <?php // echo $form->field($model, 'password') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
