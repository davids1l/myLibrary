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
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Livros', ['livros/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Livros', ['livros/create'], [
                                    'class' => 'btn btn-success'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Livros Requisitados', ['livros/requisitado'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (Yii::$app->user->can('admin')) { ?>
        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Biblioteca</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Bibliotecas', ['bibliotecas/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Biblioteca', ['bibliotecas/create'], [
                                    'class' => 'btn btn-success'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Leitores</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Leitores', ['utilizador/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (Yii::$app->user->can('admin')) { ?>
        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Bibliotecários</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Bibliotecários', ['bibliotecario/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requisições</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Requisições', ['requisicao/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Requisição', ['requisicao/create'], [
                                    'class' => 'btn btn-success'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Req. Por Preparar', ['requisicao/preparar'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Req. Prontas a Levantar', ['requisicao/levantar'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Req. c/ Multa', ['multa/index'], [
                                    'class' => 'btn btn-danger'
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
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Editoras', ['editoras/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> &nbsp Consultar Autores', ['autores/index'], [
                                    'class' => 'btn btn-info'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Editora', ['editoras/create'], [
                                    'class' => 'btn btn-success'
                                ]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Autor', ['autores/create'], [
                                    'class' => 'btn btn-success'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
