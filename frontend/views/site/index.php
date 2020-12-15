<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

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

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>
    </div>


    <!--<div class="modal fade" id="regLogModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                    <li><a href="#access-security" data-toggle="tab">Access / Security</a></li>
                    <li><a href="#networking" data-toggle="tab">Networking</a></li>
                </ul>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel">Alterar Dados Pessoais</h2>
                </div>
                <?php /*$form = ActiveForm::begin([
                    'action' => ['utilizador/update', 'id' => $model->id_utilizador]]) */?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <table>
                            <tr>
                                <th><?/*= $form->field($model, 'primeiro_nome')->textInput(['value' => $model->primeiro_nome])->label('Primeiro Nome:') */?></th>
                            </tr>
                            <tr>
                                <th><?/*= $form->field($model, 'ultimo_nome')->textInput(['value' => $model->ultimo_nome])->label('Ultimo Nome:') */?></th>
                            </tr>
                            <tr>
                                <th><?/*= $form->field($userModel, 'email')->textInput(['value' => $userModel->email])->label('Email:') */?></th>
                            </tr>
                            <tr>
                                <th><?/*= $form->field($model, 'num_telemovel')->textInput(['value' => $model->num_telemovel])->label('Número de Telemóvel:') */?></th>
                            </tr>
                            <tr>
                                <th><?/*= $form->field($model, 'dta_nascimento')->Input('date', ['value' => $model->dta_nascimento])->label('Data de Nascimento:') */?></th>
                            </tr>
                            <tr>
                                <th><?/*= $form->field($model, 'nif')->textInput(['value' => $model->nif])->label('NIF:') */?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div class="modal-footer">
                    <?/*= Html::submitButton('Guardar Alterações', ['class' => 'btn-perfil']) */?>
                </div>
                <?php /*ActiveForm::end() */?>
            </div>
        </div>
    </div>-->
</div>
