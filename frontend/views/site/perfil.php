<?php

/* @var $this yii\web\View */

use Carbon\Carbon;
use yii\helpers\Html;

$this->title = 'Perfil de Utilizador';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= Html::label('Primeiro Nome:') ?><br>
            <?= Html::input('string', 'primeiro_nome', '')?><br><br>

            <?= Html::label('Apelido:') ?><br>
            <?= Html::input('string', 'apelido', '') ?><br><br>

            <?= Html::label('Email:') ?><br>
            <?= Html::input('string', 'email', '') ?><br><br>

            <?= Html::label('Data de nascimento:') ?><br>
            <?= Html::input('date', 'dataNascimento', '') ?><br><br>


            <?= Html::label('NIF:') ?><br>
            <?= Html::input('string', 'nif', '') ?><br><br>

            <?= Html::label('Nº de telefone:') ?><br>
            <?= Html::input('string', 'nrTelefone', '') ?><br><br><br>

            <?= Html::button('Alterar palavra-passe') ?><br><br>

            <?= Html::button('Alterar Dados') ?>

        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

