<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Registar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-4">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Primeiro do nome') ?>

            <?= $form->field($model, 'email')->label('Apelido') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'email')->label('Data de Nascimento') ?>

            <?= $form->field($model, 'email')->label('NIF') ?>

            <?= $form->field($model, 'email')->label('Nº de telefone') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>

            <?= $form->field($model, 'email')->label('Confirmar Palavra-Passe') ?>

            <div class="form-group">
                <?= Html::submitButton('Registar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

