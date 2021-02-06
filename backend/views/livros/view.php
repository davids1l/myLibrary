<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Livro */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Livros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="livro-view">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <br>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $model->id_livro], ['class' => 'btnAcao']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->id_livro], [
            'class' => 'btnAcao',
            'data' => [
                'confirm' => 'Deseja eliminar o livro ' . $model->titulo . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-2">
            <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $model->capa, ['id' => 'imgCapa', 'style' => 'width: 100%; margin: 10% auto;'])?>
        </div>
        <div class="col-md-10">
            <p>Título: <?= Html::label($model->titulo) ?></p>
            <p>Autor: <?= Html::label($model->autor->nome_autor) ?></p>
            <p>Editora: <?= Html::label($model->editora->designacao) ?></p>
            <p>ISBN: <?= Html::label($model->isbn) ?></p>
            <p>Ano: <?= Html::label($model->ano) ?></p>
            <p>Páginas: <?= Html::label($model->paginas) ?></p>
            <p>Género: <?= Html::label($model->genero) ?></p>
            <p>Idioma: <?= Html::label($model->idioma) ?></p>
            <p>Formato: <?= Html::label($model->formato) ?></p>
            <p>Biblioteca: <?= Html::label($model->biblioteca->nome) ?></p>
            <p>Sinopse: </p>
            <div class="divSinopseDetalhes">
                <p class="sinopseDetalhes"><b><?= $model->sinopse ?></b></p>
            </div>
        </div>
    </div>

</div>
