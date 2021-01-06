<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Modal para abrir o login e o registo -->
    <div class="modal fade" id="regLogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <div class="modal-content">
                <div class="modal-c-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php if ($model->primeiro_nome == null) { ?>
                            <li class="nav-item active">
                                <a class="nav-link" href="#login" data-toggle="tab" role="tab"><b>Login</b></a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#login" data-toggle="tab" role="tab"><b>Login</b></a>
                            </li>
                        <?php } ?>

                        <?php if ($model->primeiro_nome != null) { ?>
                            <li class="nav-item active">
                                <a class="nav-link" href="#registar" data-toggle="tab" role="tab"><b>Registar</b></a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item-registar">
                                <a class="nav-link" href="#registar" data-toggle="tab" role="tab"><b>Registar</b></a>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="tab-content">
                        <?php if ($model->primeiro_nome == null){ ?>
                        <div class="tab-pane fade in active" id="login" role="tabpanel">
                            <?php }else{ ?>
                            <div class="tab-pane fade" id="login" role="tabpanel">
                                <?php } ?>
                                <div class="modal-body mb-1">
                                    <p>Preencha os campos para fazer login:</p>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => ['site/login']]); ?>
                                            <?= $form->field($modelLogin, 'email')->textInput(['autofocus' => true]) ?>

                                            <?= $form->field($modelLogin, 'password')->passwordInput()->label('Palavra-passe') ?>

                                            <div class="text-center mt-2">
                                                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <?php if ($model->primeiro_nome == null){ ?>
                            <div class="tab-pane fade" id="registar" role="tabpanel">
                                <?php }else{ ?>
                                <div class="tab-pane fade in active" id="registar" role="tabpanel">
                                    <?php } ?>

                                    <div class="modal-body mb-1">
                                        <p>Preencha todos os campos para se registar:</p>
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-6">
                                                <div class="md-form form-sm mb-5">
                                                    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'action' => ['site/signup']]); ?>
                                                    <?= $form->field($model, 'primeiro_nome')->textInput(['autofocus' => true])->label('Primeiro nome') ?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'ultimo_nome')->label('Apelido') ?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'email')?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'dta_nascimento')->label('Data de Nascimento')->input('date') ?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'nif')->label('NIF') ?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'num_telemovel')->label('Nº de telefone') ?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>
                                                </div>
                                                <div class="md-form form-sm mb-5">
                                                    <?= $form->field($model, 'confirmarPassword')->passwordInput()->label('Confirmar Palavra-Passe') ?>
                                                </div>


                                                <div class="text-center form-sm mt-2">
                                                    <?= Html::submitButton('Registar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
