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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $model->id_livro], [
            'class' => 'btn btn-success'
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $model->id_livro], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row rowStyling">
        <div class="col-md-2">
            <?= Html::img($model->capa, ['style'=> 'width: 100%; margin: 10% auto;'])?>
        </div>
        <br />
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




    <?php /* DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_livro',
            'titulo',
            'isbn',
            'ano',
            'paginas',
            'genero',
            'idioma',
            'formato',
            'capa',
            'sinopse:ntext'
        ],
    ])*/ ?>

</div>
