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
        'class' => 'btn btn-success',
        'id' => 'adicionarLivro'
    ]); ?>
    <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar todos', ['livros/index'], [
        'class' => 'btn btn-info'
    ]); ?>
    <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar requisitados', ['livros/requisitado'], [
        'class' => 'btn btn-info'
    ]); ?>
    <?php ActiveForm::end() ?>
    <br/>
    <?php if($livros != null) { ?>
        <?php foreach ($livros as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid gridLivros" style="height: 400px">
                <div class="capa">
                    <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                        <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livro->capa, ['id'=> 'imgCapa', 'style' => 'width: 140px; height: 220px;'])?>
                    </a>
                </div>
                <div class="book-info">
                    <h4><b><?= Html::encode($livro->titulo)?></b></h4>
                    <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                    <h6><?= Html::encode($livro->genero)?></h6>
                    <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                    <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                </div>
                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['livros/view', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-primary book-buttons'
                ])?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-danger book-buttons',
                    'data' => [
                        'confirm' => 'Tem a certeza que pretende eliminar este livro?',
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
