<?php

/* @var $this yii\web\View */

$this->title = 'MyLibrary';

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Bem vindo à sua Biblioteca digital!</h1>

        <p class="lead">Aceda à sua Biblioteca em qualquer lugar</p>

        <?= Html::a('Crie uma conta', ['site/showmodal'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 5%;']); ?>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2 class="text-center">Feedback</h2>

                <p> Deixe o seu feedback sobre os livros que requisitou
                    através do nosso sistema de comentários, onde poderá ler
                    a opinião de outros leitores!
                </p>

            </div>
            <div class="col-lg-4">
                <h2 class="text-center">Catálogo</h2>

                <p> Consulte já o nosso extenso catálogo de volumes, que estão
                    disponiveis nos formatos físico e digital!
                </p>

                <?= Html::a('Consulte já', ['livro/catalogo'], ['class' => 'btn btn-default center-block', 'style' => 'margin-top: 3%;']); ?>

            </div>
            <div class="col-lg-4">
                <h2 class="text-center" >Requisições</h2>

                <p> Pode utilizar o nosso sistema de requisições para levantar
                    os seus volumes na biblioteca que se encontra mais próxima
                    de si!
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
