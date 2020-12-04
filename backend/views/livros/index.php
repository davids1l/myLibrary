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

    <h1><?php // Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Livro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_livro',
            'titulo',
            'isbn',
            'ano',
            'paginas',
            //'genero',
            //'idioma',
            //'formato',
            //'capa',
            //'sinopse:ntext',
            //'id_editora',
            //'id_biblioteca',
            //'id_autor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>

        <h1><?= Html::encode($this->title)?></h1>
    <hr>


    <?php $form = ActiveForm::begin([
        'id' => 'pesquisa-form',
        'options' => ['class' => 'form-horizontal'],
        'action' => ['livros/index']
    ]) ?>

    <?= $form->field($searchModel, 'titulo'); ?>
    <?= Html::submitButton('Pesquisar', ['className' => 'pesquisa']); ?>
    <button class="buttonPanel"><?= Html::a('Adicionar Livros', ['livros/create']); ?></button>
    <?php ActiveForm::end() ?>

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
                <?= Html::a('View', ['livros/view', 'id' => $livro->id_livro])?>
                <?= Html::a('Update', ['update', 'id' => $livro->id_livro], [
                    'style' => 'color: green'
                ]) ?>
                <?= Html::a('Delete', ['delete', 'id' => $livro->id_livro], [
                    'style' => 'color: red',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php }
    } ?>

    <?php /* $this->render('_search', [
        'model' => $model,
    ]) */?>


</div>
