<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Painel';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Livros</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                               <?= Html::a('Consultar Livros', ['livros/index'], [
                                        'class' => 'btn btn-primary'
                                    ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('Adicionar Livros', ['livros/create'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Biblioteca</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('Consultar Bibliotecas', ['bibliotecas/index'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('Adicionar Biblioteca', ['bibliotecas/create'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Utilizadores</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('Gerir Utilizadores', ['site/index'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requisições</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('Consultar Requisições', ['site/index'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('Adicionar Requisição', ['site/index'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Diversos</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('Adicionar Editora', ['editoras/create'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('Adicionar Autor', ['autores/create'], [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
