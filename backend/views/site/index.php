<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Painel';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="titlePanelDiv">
                <h3 class="titlePanel">Livros</h3>
            </div>
            <br />
            <div class="col-md-2">
                    <button class="buttonPanel"><?= Html::a('Consultar Livros', ['livros/index']) ?></button>
            </div>
            <div class="col-md-2">
                <button class="buttonPanel"><?= Html::a('Adicionar Livros', ['livros/create']) ?></button>
            </div>
            <br />
        </div>

        <div class="row">
            <div class="titlePanelDiv">
                <h3 class="titlePanel">Biblioteca</h3>
            </div>
            <br />
            <div class="col-md-2">
                <button class="buttonPanel"><?= Html::a('Consultar Bibliotecas', ['bibliotecas/index']) ?></button>
            </div>
            <div class="col-md-2">
                <button class="buttonPanel"><?= Html::a('Adicionar Biblioteca', ['bibliotecas/create']) ?></button>
            </div>
            <br />
        </div>

        <div class="row">
            <div class="titlePanelDiv">
                <h3 class="titlePanel">Utilizadores</h3>
            </div>
            <br />
            <div class="col-md-2">
                <button class="buttonPanel"><?= Html::a('Gerir Utilizadores', ['livros/index']) ?></button>
            </div>
            <br />
        </div>

        <div class="row">
            <div class="titlePanelDiv">
                <h3 class="titlePanel">Requisições</h3>
            </div>
            <br />
            <div class="col-md-2">
                <button class="buttonPanel"><?= Html::a('Consultar Requisições', ['site/index']) ?></button>
            </div>
            <br />
            <div class="col-md-2">
                <button class="buttonPanel"><?= Html::a('Adicionar Requisição', ['site/index']) ?></button>
            </div>
            <br />
        </div>

    </div>
</div>
