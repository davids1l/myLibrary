<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login de Leitores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Email') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                Esqueceu-se da palavra-passe?  <?= Html::a('Clique aqui', ['site/request-password-reset']) ?>.
                <br>
                Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>