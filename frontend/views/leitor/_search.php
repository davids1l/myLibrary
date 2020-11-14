<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LeitorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leitor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_leitor') ?>

    <?= $form->field($model, 'num_leitor') ?>

    <?= $form->field($model, 'bloqueado') ?>

    <?= $form->field($model, 'dta_bloqueado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
