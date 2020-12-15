<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LivroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Livros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="livro-index">
        <h1><?= Html::encode($this->title)?></h1>
    <hr>


    <?php $form = ActiveForm::begin([
        'id' => 'pesquisa-form',
        'options' => ['class' => 'form-horizontal'],
        'action' => ['livros/index']
    ]) ?>

    <?= $form->field($searchModel, 'titulo')->label('Indique o título a pesquisar: '); ?>
    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Pesquisar', ['className' => 'pesquisa', 'class' => 'btn btn-primary']); ?>

    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar Livros', ['livros/create'], [
        'class' => 'btn btn-success'
    ]); ?>
    <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar todos', ['livros/index'], [
        'class' => 'btn btn-info'
    ]); ?>
    <?php ActiveForm::end() ?>
    <br/>
    <?php if($livros != null) { ?>
        <?php foreach ($livros as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid gridLivros">
                <div class="capa">
                    <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                        <?= Html::img($livro->capa, ['id'=> 'imgCapa'])?>
                    </a>
                </div>
                <div class="book-info">
                    <h4><?= Html::encode($livro->titulo)?></h4>
                    <h5><?= Html::encode($livro->genero)?></h5>
                    <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                    <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                </div>
                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> Detalhes', ['livros/view', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-primary book-buttons'
                ])?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['update', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-success book-buttons'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-danger book-buttons',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php }
    } else { ?>
        <br/>
        <p>Parece que não foram encontrados livros.</p>
    <?php } ?>

    <?php /* $this->render('_search', [
        'model' => $model,
    ]) */?>


</div>
