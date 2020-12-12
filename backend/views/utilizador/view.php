<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Utilizador */

$this->title = $model->primeiro_nome . " " . $model->ultimo_nome;
$this->params['breadcrumbs'][] = ['label' => 'Leitores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="utilizador-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if($model->bloqueado == 1){ ?>
            <?= Html::a('Desbloquear', ['bloquear', 'id' => $model->id_utilizador], [
                'data' => [
                    'confirm' => 'Tem a certeza que quer desbloquear o leitor com o nº ' . $model->numero . '?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } else { ?>
            <?= Html::a('Bloquear', ['bloquear', 'id' => $model->id_utilizador], [
                'data' => [
                    'confirm' => 'Tem a certeza que quer bloquear o leitor com o nº ' . $model->numero . '?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>

            <?= Html::a('Eliminar', ['delete', 'id' => $model->id_utilizador], [
            'data' => [
                'confirm' => 'Tem a certeza que quer eliminar o leitor com o nº ' . $model->numero . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row" style="background-color: white">
        <div class="col-sm-6">
            <div class="row" style="background-color: white; margin: 0">
                <div class="col-sm-6">
                    <h4 style="float: right">Primeiro Nome:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->primeiro_nome ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Último Nome:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->ultimo_nome ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Nº de Leitor:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->numero ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Bloqueado:</h4>
                </div>
                <div class="col-sm-6">
                    <?php
                    if($model->bloqueado == null){ ?>
                        <h4>&nbsp</h4>
                    <?php }else{ ?>
                        <h4>Bloqueado</h4>
                    <?php } ?>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Data do Bloqueio:</h4>
                </div>
                <div class="col-sm-6">
                    <?php
                    if($model->bloqueado == null){ ?>
                        <h4>&nbsp</h4>
                    <?php }else{ ?>
                        <h4><?= $model->dta_bloqueado ?></h4>
                    <?php } ?>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Data de Nascimento:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->dta_nascimento ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">NIF:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->nif ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Nº de Telemóvel:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->num_telemovel ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Data de Registo:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->dta_registo ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Foto de Perfil:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->foto_perfil ?></h4>
                </div>

                <div class="col-sm-6">
                    <h4 style="float: right">Email:</h4>
                </div>
                <div class="col-sm-6">
                    <h4><?= $model->user->email ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
