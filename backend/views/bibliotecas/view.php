<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\Models\Biblioteca */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="biblioteca-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_biblioteca], [
            'class' => '',
            'style' => 'color: green'
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_biblioteca], [
            'class' => '',
            'style' => 'color: red',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-10">
            <br/>
            <p>ID: <?= Html::label($model->id_biblioteca) ?></p>
            <p>Nome: <?= Html::label($model->nome) ?></p>
            <p>Código Postal <?= Html::label($model->cod_postal) ?></p>
        </div>
    </div>

</div>
