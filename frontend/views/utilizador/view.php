<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $utilizador app\models\Utilizador */

$this->title = /*$utilizador->id_utilizador*/
    'Perfil de Leitor';
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
                    <th><?= Html::img($utilizador->foto_perfil, ['width' => '234px', 'height' => '234px']) ?></th>
                </tr>
                <tr>
                    <th><br></th>
                </tr>
                <tr>
                    <th class="text-center"><?= Html::button('Alterar Imagem') ?></th>
                </tr>
            </table>
        </div>

        <div class="col-sm-4">
            <table>
                <tr>
                    <th><h4 style="float: right">Nº de Leitor: &nbsp</h4></th>
                    <th><h4><?= Html::encode($utilizador->numero) ?></h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Nome: &nbsp</h4></th>
                    <th><h4><?= Html::encode($utilizador->primeiro_nome . " " . $utilizador->ultimo_nome) ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Email: &nbsp</h4></th>
                    <th><h4><?= Html::encode(Yii::$app->user->identity->email) ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Nº de telemóvel: &nbsp</h4></th>
                    <th><h4><?= Html::encode($utilizador->num_telemovel) ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">Data de Nascimento: &nbsp</h4></th>
                    <th><h4><?= Carbon::parse($utilizador->dta_nascimento)->format('d/m/Y') ?> </h4></th>
                </tr>
                <tr>
                    <th><h4 style="float: right">NIF: &nbsp</h4></th>
                    <th><h4><?= Html::encode($utilizador->nif) ?> </h4></th>
                </tr>
                <tr>
                    <th><!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#perfilModal">
                            Alterar dados
                        </button>
                    </th>
                </tr>
            </table>
        </div>
        <div class="col-sm-4"></div>
    </div>


    <!-- Modal -->
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
                        'id' => 'form-perfil',
                    'action' => ['utilizador/update', 'id' => $utilizador->id_utilizador]]) ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="modal-body col-sm-6">
                        <table>
                            <tr>
                                <th><?= $form->field($model, 'primeiro_nome')->textInput(['value' => $utilizador->primeiro_nome])->label('Primeiro Nome:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'ultimo_nome')->textInput(['value' => $utilizador->ultimo_nome])->label('Ultimo Nome:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->email])->label('Email:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'num_telemovel')->textInput(['value' => $utilizador->num_telemovel])->label('Número de Telemóvel:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'dta_nascimento')->Input('date', ['value' => $utilizador->dta_nascimento])->label('Data de Nascimento:') ?></th>
                            </tr>
                            <tr>
                                <th><?= $form->field($model, 'nif')->textInput(['value' => $utilizador->nif])->label('NIF:') ?></th>
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

</div>
