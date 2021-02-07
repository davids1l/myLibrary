<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $utilizador app\models\Utilizador */

$this->title = 'Perfil de Leitor';
//$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="utilizador-view">

    <h1 class="topicos" style="text-transform: uppercase; padding-left: 0"><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class="row perfil">

        <div class="col-md-4" style="padding: 10px">
            <div class="col-md-12 text-center card"
                 style="margin-right: 20px; margin-bottom: 20px; padding: 10px; height: 289px">
                <?= Html::img(Yii::$app->request->baseUrl . '/imgs/perfil/' . $model->foto_perfil, ['width' => '234px', 'height' => '234px', 'class' => 'imagemPerfil']) ?>
                <div class="text-right">
                    <div class="dropdown">
                        <a onclick="mostrarDropdown()" class="dropbtn glyphicon glyphicon-menu-down"
                           style="font-size: 20px"></a>
                        <div id="myDropdown" class="dropdown-perfil">
                            <a data-toggle="modal" data-target="#imageModel">
                                <div style="display: inline"><i class="fas fa-image"></i> Alterar Foto</div>
                            </a>
                            <?= Html::a('<div><i class="fas fa-times"></i> Remover Foto</div>', ['utilizador/remover-img', 'id' => $model->id_utilizador]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 card" style="padding: 10px">
                <h4 style="font-weight: bold; color: #f26b3b">Outras informações</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <h5 style="font-weight: bold">Data de Registo</h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><?= Carbon::parse($model->dta_registo)->format('d/m/Y H:i:s') ?></h5>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-8" style="padding: 10px">
            <div class="col-md-12 card" style="padding: 10px; margin-bottom: 20px">
                <div class="row">
                    <div class="col-sm-4">
                        <h4 style="font-weight: bold">Nº de Leitor</h4>
                    </div>
                    <div class="col-sm-8 dados">
                        <h4><?= Html::encode($model->numero) ?></h4>
                    </div>
                </div>

                <hr style="margin: 3px;">

                <div class="row">
                    <div class="col-sm-4">
                        <h4 style="font-weight: bold">Nome</h4>
                    </div>
                    <div class="col-sm-8 dados">
                        <h4><?= Html::encode($model->primeiro_nome . " " . $model->ultimo_nome) ?> </h4>
                    </div>
                </div>

                <hr style="margin: 3px;">

                <div class="row">
                    <div class="col-sm-4">
                        <h4 style="font-weight: bold">Email</h4>
                    </div>
                    <div class="col-sm-8 dados">
                        <h4><?= Html::encode($userModel->email) ?> </h4>
                    </div>
                </div>

                <hr style="margin: 3px;">

                <div class="row">
                    <div class="col-sm-4">
                        <h4 style="font-weight: bold">Telemóvel</h4>
                    </div>
                    <div class="col-sm-8 dados">
                        <h4><?= Html::encode($model->num_telemovel) ?> </h4>
                    </div>
                </div>

                <hr style="margin: 3px;">

                <div class="row">
                    <div class="col-sm-4">
                        <h4 style="font-weight: bold">Data de Nascimento</h4>
                    </div>
                    <div class="col-sm-8 dados">
                        <h4><?= Carbon::parse($model->dta_nascimento)->format('d/m/Y') ?> </h4>
                    </div>
                </div>

                <hr style="margin: 3px;">

                <div class="row">
                    <div class="col-sm-4">
                        <h4 style="font-weight: bold">NIF</h4>
                    </div>
                    <div class="col-sm-7 dados">
                        <h4><?= Html::encode($model->nif) ?> </h4>
                    </div>
                    <div class="col-sm-1">
                        <div class="dropdown">
                            <a onclick="mostrarDropdownDados()" class="dropbtn glyphicon glyphicon-menu-down"
                               style="font-size: 20px"></span></a>
                            <div id="myDropdownDados" class="dropdown-perfil" style="width: max-content">
                                <a data-toggle="modal" data-target="#perfilModal">
                                    <div style="display: inline"><i class="fas fa-user"></i> Alterar Dados</div>
                                </a>
                                <a data-toggle="modal" data-target="#passwordModal">
                                    <div style="display: inline"><i class="fas fa-lock"></i> Alterar Palavra-passe</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 card">
                <div class="col-md-12" style="margin-right: 20px; padding: 10px">
                    <h4><b style="color: #f26b3b">Estatísticas</b></h4>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12" style="display: flex">

                    <div class="col-md-6 card" style="margin-top: 10px; margin-right: 10px">
                        <div class="row">
                            <div class="col-sm-7">
                                <h5 style="font-weight: bold">Autor favorito</h5>
                            </div>
                            <div class="col-sm-5">
                                <h5><?= $autorFavorito ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 card" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-sm-7">
                                <h5 style="font-weight: bold">Gênero favorito</h5>
                            </div>
                            <div class="col-sm-5">
                                <h5><?= $generoFavorito ?></h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6 card" style="margin-top: 10px">
                <div class="row">
                    <div class="col-sm-7">
                        <h5 style="font-weight: bold">Nº de livros requisitados</h5>
                    </div>
                    <div class="col-sm-5">
                        <h5><?= $livrosRequisitados ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para alterar dados -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="topicos" id="exampleModalLabel">ALTERAR DADOS</h2>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['utilizador/update', 'id' => $model->id_utilizador], 'id' => 'formAlterar']) ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <table>
                            <tr>
                                <th><?= $form->field($model, 'primeiro_nome')->textInput(['value' => $model->primeiro_nome])->label('Nome:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'ultimo_nome')->textInput(['value' => $model->ultimo_nome])->label('Apelido:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($userModel, 'email')->textInput(['value' => $userModel->email])->label('Email:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'num_telemovel')->textInput(['value' => $model->num_telemovel])->label('Número de Telemóvel:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'dta_nascimento')->Input('date', ['value' => $model->dta_nascimento])->label('Data de Nascimento:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'nif')->textInput(['value' => $model->nif])->label('NIF:') ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn-perfil']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>


    <!-- Modal para alterar password -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="topicos" id="exampleModalLabel">ALTERAR PALAVRA-PASSE</h2>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['utilizador/update-password', 'id' => $model->id_utilizador]]) ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <?= $form->field($userModel, 'atual_password')->passwordInput(['value' => ""])->label('Palavra-passe Atual:') ?>
                        <?= $form->field($userModel, 'nova_password')->passwordInput(['value' => ""])->label('Nova Palavra-passe:') ?>
                        <?= $form->field($userModel, 'conf_password')->passwordInput(['value' => ""])->label('Confirmar Nova Palavra-passe:') ?>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn-perfil']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>


    <!-- Modal para alterar a imagem -->
    <div class="modal fade" id="imageModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="topicos" id="exampleModalLabel">ALTERAR FOTO</h2>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['utilizador/upload-img', 'id' => $model->id_utilizador]]) ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <table>
                            <tr>
                                <th><?= $form->field($modelUpload, 'imageFile')->fileInput()->label('') ?></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn-perfil']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

</div>
