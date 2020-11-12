<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AvaliacaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avaliacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_avaliacao') ?>

    <?= $form->field($model, 'data_avaliacao') ?>

    <?= $form->field($model, 'avaliacao') ?>

    <?= $form->field($model, 'id_livro') ?>

    <?= $form->field($model, 'id_utilizador') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
