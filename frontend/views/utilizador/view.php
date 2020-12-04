<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $utilizador app\models\Utilizador */

$this->title = /*$utilizador->id_utilizador*/'Perfil de Leitor';
//$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="utilizador-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>


    <div class="row">
        <div class="col-sm-4">
            <table>
                <tr>
                    <th><?= Html::img(Yii::$app->request->baseUrl .'/imgs/perfil/' . $model->foto_perfil, ['width' => '234px', 'height' => '234px']) ?></th>
                </tr>
                <tr>
                    <th><br></th>
                </tr>
                <tr>
                    <th>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModel">Alterar Imagem</button>
                    </th>
                </tr>
                <tr>
                    <th>
                        <?php $form = ActiveForm::begin([
                            'action' => ['utilizador/remover-img', 'id' => $model->id_utilizador]]) ?>
                        <?= Html::submitButton('Remover Imagem', ['class' => 'btn btn-primary']) ?>
                        <?php ActiveForm::end() ?>
                    </th>
                </tr>
            </table>
        </div>

        <div class="col-sm-4">
            <table>
                <tr>
                    <th><h4 style="float: right">Nº de Leitor: &nbsp</h4></th>
                    <th><h4><?= Html::encode($model->numero) ?></h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Nome: &nbsp</h4></th>
                    <th><h4><?= Html::encode($model->primeiro_nome . " " . $model->ultimo_nome) ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Email: &nbsp</h4></th>
                    <th><h4><?= Html::encode($userModel->email) ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Nº de telemóvel: &nbsp</h4></th>
                    <th><h4><?= Html::encode($model->num_telemovel) ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Data de Nascimento: &nbsp</h4></th>
                    <th><h4><?= Carbon::parse($model->dta_nascimento)->format('d/m/Y') ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">NIF: &nbsp</h4></th>
                    <th><h4><?= Html::encode($model->nif) ?> </h4></th>
                </tr>
                <tr>
                    <th>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#perfilModal">Alterar dados</button>
                    </th>
                </tr>
                <tr>
                    <th>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passwordModal">Alterar Palavra-Passe</button>
                    </th>
                </tr>
            </table>
        </div>
        <div class="col-sm-4"></div>
    </div>


    <!-- Modal para alterar dados -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel">Alterar Dados Pessoais</h2>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['utilizador/update', 'id' => $model->id_utilizador]]) ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <table>
                            <tr>
                                <th><?= $form->field($model, 'primeiro_nome')->textInput(['value' => $model->primeiro_nome])->label('Primeiro Nome:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'ultimo_nome')->textInput(['value' => $model->ultimo_nome])->label('Ultimo Nome:') ?></th>
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
                    <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-primary']) ?>
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
                    <h2 class="modal-title" id="exampleModalLabel">Alterar Palavra-passe</h2>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['utilizador/update-password', 'id' => $model->id_utilizador]]) ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <table>
                            <!--<tr>
                                <th><?/*= $form->field($userModel, 'password_hash')->passwordInput(['value' => ""])->label('Palavra-passe Atual:') */?></th>
                            </tr>-->
                            <tr>
                                <th><?= $form->field($userModel, 'password_hash')->passwordInput(['value' => ""])->label('Nova Palavra-passe:') ?></th>
                            </tr>
                            <!--<tr>
                                <th><?/*= $form->field($userModel, 'password_hash')->passwordInput(['value' => ""])->label('Confirmar Nova Palavra-passe:') */?></th>
                            </tr>-->
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Alterar Palavra-passe', ['class' => 'btn btn-primary']) ?>
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
                    <h2 class="modal-title" id="exampleModalLabel">Alterar Imagem do Perfil</h2>
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
                    <?= Html::submitButton('Alterar Imagem', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

</div>
