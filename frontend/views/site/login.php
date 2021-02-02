<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sessão';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="text-center tituloLogin"><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email', ['inputTemplate' => '<div class="input-group"><i style="font-size: 20px; color: #f26b3b" class="fas fa-user input-group-addon"></i>{input}</div>'])->textInput(['placeholder' => 'endereço de email', 'style' => 'height: 40px; font-size: 16px'])->label(false) ?>

                <?= $form->field($model, 'password', ['inputTemplate' => '<div class="input-group" style="width: 555px"><i style="font-size: 20px; width:43px; color: #f26b3b" class="fa fa-lock input-group-addon"></i>{input}</div>'])->passwordInput(['placeholder' => 'palavra-passe', 'style' => 'height: 40px; font-size: 16px'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Manter sessão iniciada') ?>

                <!--<div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?/*= Html::a('reset it', ['site/request-password-reset']) */?>.
                    <br>
                    Need new verification email? <?/*= Html::a('Resend', ['site/resend-verification-email']) */?>
                </div>-->

                <div class="form-group">
                    <?= Html::submitButton('Iniciar Sessão', ['class' => 'btnLogin', 'name' => 'login-button', 'style' => 'width:555px']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <div class="divLinkRegistar text-center" ><?= Html::a('Não tem conta? Registe-se aqui', ['/site/signup'], ['class' => 'linkRegistar']) ?></div>
        </div>
    </div>
</div>
