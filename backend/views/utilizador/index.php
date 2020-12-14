<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UtilizadorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leitores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>


    <div>
        <?= Html::button('Criar Leitor', ['data-toggle' => 'modal', 'data-target' => '#criarLeitorModal']) ?>
    </div>
    <br>


    <table class="tableLeitores">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Nº Leitor</th>
            <th>Email</th>
            <th>Bloqueado</th>
            <th>Data do bloqueio</th>
            <th>Data de nascimento</th>
            <th>NIF</th>
            <th>Nº de telemóvel</th>
            <th>Data de registo</th>
            <th>Imagem</th>
        </tr>

        <?php
        foreach ($utilizadores as $utilizador) { ?>
            <tr>
                <th><h4><?= Html::encode($utilizador->id_utilizador); ?></h4></th>
                <th><h4><?= Html::encode($utilizador->primeiro_nome . " " . $utilizador->ultimo_nome); ?></h4></th>
                <th><h4><?= Html::encode($utilizador->numero); ?></h4></th>
                <th><h4><?= Html::encode($utilizador->user->email); ?></h4></th>

                <?php
                if($utilizador->bloqueado == 1){ ?>
                    <th><h4>Bloqueado</h4></th>
                <?php }else{ ?>
                    <th></th>
                <?php } ?>

                <?php if(!$utilizador->dta_bloqueado == null){ ?>
                    <th><h4><?=Carbon::parse(Html::encode($utilizador->dta_bloqueado))->format('d/m/Y H:i:s');?> </h4></th>
                        <?php }else{ ?>
                    <th></th>
                <?php } ?>

                <th><h4><?= Carbon::parse(Html::encode($utilizador->dta_nascimento))->format('d/m/Y'); ?></h4></th>
                <th><h4><?= Html::encode($utilizador->nif); ?></h4></th>
                <th><h4><?= Html::encode($utilizador->num_telemovel); ?></h4></th>
                <th><h4><?= Carbon::parse(Html::encode($utilizador->dta_registo))->format('d/m/Y H:i:s'); ?></h4></th>
                <th><?= Html::img(Yii::$app->request->baseUrl . '../../../frontend/web/imgs/perfil/' . $utilizador->foto_perfil, ['width' => '60px', 'height' => '60px']) ?></th>
                <th><?= Html::a('<i class="glyphicon glyphicon-eye-open">', ['utilizador/view', 'id' => $utilizador->id_utilizador]) ?></th>

                <?php if($utilizador->bloqueado == 1){ ?>
                    <th><?= Html::a('<i class="glyphicon glyphicon-ok-circle">', ['utilizador/bloquear', 'id' => $utilizador->id_utilizador], [
                            'data' => [
                                'confirm' => 'Tem a certeza que quer desbloquear o leitor com o nº ' . $utilizador->numero . '?',
                                'method' => 'post',
                            ],
                        ]) ?></th>
                <?php }else{ ?>
                    <th><?= Html::a('<i class="glyphicon glyphicon-ban-circle">', ['utilizador/bloquear', 'id' => $utilizador->id_utilizador], [
                            'data' => [
                                'confirm' => 'Tem a certeza que quer bloquear o leitor com o nº ' . $utilizador->numero . '?',
                                'method' => 'post',
                            ],
                        ]) ?></th>
                <?php } ?>
                <th><?= Html::a('<i class="glyphicon glyphicon-trash">', ['utilizador/delete', 'id' => $utilizador->id_utilizador], [
                        'data' => [
                            'confirm' => 'Tem a certeza que quer eliminar o leitor com o nº ' . $utilizador->numero . '?',
                            'method' => 'post',
                        ],
                    ]) ?></th>
        <?php } ?>
    </table>
</div>



<!-- Modal para criar leitor -->
<div class="modal fade" id="criarLeitorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="exampleModalLabel">Criar Leitor</h2>
            </div>
            <div class="row" style="background-color: white">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <?php $form = ActiveForm::begin([
                        'action' => ['utilizador/create']]) ?>
                    <div class="row" style="background-color: white">
                        <?= $form->field($model, 'primeiro_nome')->textInput(['autofocus' => true])->label('Primeiro nome') ?>
                        <?= $form->field($model, 'ultimo_nome')->label('Apelido') ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'dta_nascimento')->label('Data de Nascimento')->input('date') ?>
                        <?= $form->field($model, 'nif')->label('NIF') ?>
                        <?= $form->field($model, 'num_telemovel')->label('Nº de telefone') ?>
                        <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>
                        <?= $form->field($model, 'confirmarPassword')->passwordInput()->label('Confirmar Palavra-Passe') ?>
                    </div>
                    <div class="modal-footer">
                        <?= Html::submitButton('Criar Leitor', ['class' => 'btn-perfil']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
                <div class="col-sm-2"></div>
            </div>

        </div>
    </div>
</div>
