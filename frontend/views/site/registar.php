<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Registar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'primeiro_nome')->textInput(['autofocus' => true])->label('Primeiro nome') ?>
            <?= $form->field($model, 'ultimo_nome')->label('Apelido') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'dta_nascimento')->label('Data de Nascimento')->input('date') ?>
            <?= $form->field($model, 'nif')->label('NIF') ?>
            <?= $form->field($model, 'num_telemovel')->label('Nº de telefone') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>
            <?= $form->field($model, 'confirmarPassword')->passwordInput()->label('Confirmar Palavra-Passe') ?>
            <div class="form-group">
                <?= Html::submitButton('Registar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

