<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sessão';
?>
<div class="site-login">
    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>
    <br>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <p>Preencha os campos para fazer login:</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Palavra-passe') ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Manter sessão iniciada') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Iniciar Sessão', ['class' => 'btnAcao', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>