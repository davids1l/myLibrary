<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LivroSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="livro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_livro') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'ano') ?>

    <?= $form->field($model, 'paginas') ?>

    <?php // echo $form->field($model, 'genero') ?>

    <?php // echo $form->field($model, 'idioma') ?>

    <?php // echo $form->field($model, 'formato') ?>

    <?php // echo $form->field($model, 'capa') ?>

    <?php // echo $form->field($model, 'sinopse') ?>

    <?php // echo $form->field($model, 'id_editora') ?>

    <?php // echo $form->field($model, 'id_biblioteca') ?>

    <?php // echo $form->field($model, 'id_autor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
