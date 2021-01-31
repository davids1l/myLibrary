<?php

/* @var $this yii\web\View */

$this->title = 'MyLibrary';

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>


<div class="site-index">

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-bottom: 3%;">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <?= Html::img('/myLibrary/frontend/web/imgs/diversos/carousel_1.jpg') ?>
                <div class="carousel-caption">
                    <!-- <button class="btn btn-success btn-sm">CATÁLOGO</button> -->
                </div>
            </div>
            <div class="item">
                <img src="..." alt="...">
                <div class="carousel-caption">

                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
    </div>

    <div class="col-lg-12 novos">
        <h3 class="sub-titulo">NOVOS LANÇAMENTOS</h3>
        <?php if ($recentes != null) { ?>
            <?php foreach ($recentes as $recente) { ?>
                <div class="col-xs-12 col-md-2 col-lg-2 catalogo-grid">
                    <div class="capa">
                        <a href="<?= Url::to(['livro/detalhes', 'id' => $recente->id_livro]) ?>">
                            <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $recente->capa, [
                                'id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;'
                            ]) ?>
                        </a>
                    </div>
                    <div class="book-info">
                        <h4><?= Html::encode($recente->titulo) ?></h4>
                        <h5>de <?= Html::encode($recente->autor->nome_autor)?></h5>
                        <!-- <h6><?= Html::encode($recente->genero) ?></h6> -->
                        <h6>Idioma: <?= Html::encode($recente->idioma) ?></h6>
                        <h6>Formato: <?= Html::encode($recente->formato) ?></h6>
                        <?php
                        if ($this->context->verificarEmRequisicao($recente->id_livro) == true) { ?>
                            <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                        <?php } else { ?>
                            <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                        <?php } ?>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>Não existem livros.</p>
        <?php } ?>
    </div>

    <div class="col-lg-12 maisRequisitados">
        <hr>
        <?php if ($maisRequisitados != null) { ?>
            <h3 class="sub-titulo">MAIS REQUISITADOS</h3>
            <?php foreach ($maisRequisitados as $livro) { ?>
                <div class="col-xs-12 col-md-2 catalogo-grid">
                    <div class="capa">
                        <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                            <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, [
                                'id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;'
                            ]) ?>
                        </a>
                    </div>
                    <div class="book-info">
                        <h4><?= Html::encode($livro->titulo) ?></h4>
                        <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                        <h6><?= Html::encode($livro->genero) ?></h6>
                        <h6>Idioma: <?= Html::encode($livro->idioma) ?></h6>
                        <h6>Formato: <?= Html::encode($livro->formato) ?></h6>
                        <?php
                        if ($this->context->verificarEmRequisicao($livro->id_livro) == true) { ?>
                            <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                        <?php } else { ?>
                            <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                        <?php } ?>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>Não existem livros.</p>
        <?php } ?>
    </div>

    <div class="col-lg-12 maisFavoritos">
        <hr>
        <?php if ($maisFavoritos != null) { ?>
            <h3 class="sub-titulo">OS PREFERIDOS DOS LEITORES</h3>
            <?php foreach ($maisFavoritos as $livro) { ?>
                <div class="col-xs-12 col-md-2 catalogo-grid">
                    <div class="capa">
                        <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                            <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, [
                                'id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;'
                            ]) ?>
                        </a>
                    </div>
                    <div class="book-info">
                        <h4><?= Html::encode($livro->titulo) ?></h4>
                        <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                        <h6><?= Html::encode($livro->genero) ?></h6>
                        <h6>Idioma: <?= Html::encode($livro->idioma) ?></h6>
                        <h6>Formato: <?= Html::encode($livro->formato) ?></h6>
                        <?php
                        if ($this->context->verificarEmRequisicao($livro->id_livro) == true) { ?>
                            <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                        <?php } else { ?>
                            <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                        <?php } ?>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>Não existem favoritos.</p>
        <?php } ?>
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
                                <a class="nav-link" href="#registar" data-toggle="tab"
                                   role="tab"><b>Registar</b></a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item-registar">
                                <a class="nav-link" href="#registar" data-toggle="tab"
                                   role="tab"><b>Registar</b></a>
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
                                                    <?= $form->field($model, 'email') ?>
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
    </div>

</div>