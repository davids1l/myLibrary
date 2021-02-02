<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registar';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h1 class="text-center tituloRegistar"><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'primeiro_nome')->textInput(['placeholder' => 'nome', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <?= $form->field($model, 'ultimo_nome')->textInput(['placeholder' => 'apelido', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'endereço de email', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <?= $form->field($model, 'dta_nascimento')->label(false)->input('date', ['style' => 'height: 40px; font-size: 16px;']) ?>
            <?= $form->field($model, 'nif')->textInput(['placeholder' => 'NIF', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <?= $form->field($model, 'num_telemovel')->textInput(['placeholder' => 'nº de telemóvel', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'palavra-passe', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <?= $form->field($model, 'confirmarPassword')->passwordInput(['placeholder' => 'confirmar palavra-passe', 'style' => 'height: 40px; font-size: 16px;'])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Registar', ['class' => 'btnLogin', 'name' => 'signup-button', 'style' => 'width: 555px; margin-top: 10px']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="divLinkRegistar text-center" ><?= Html::a('Já tem conta? Inicie Sessão aqui', ['/site/login'], ['class' => 'linkRegistar']) ?></div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>