<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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

        <?php if($livros != null) { ?>
            <?php foreach ($livros as $livro) { ?>
                <div class="col-xs-12 col-md-2 catalogo-grid">
                    <div class="capa">
                        <a href="<?= Url::to(['livros/detalhes', 'id' => $livro->id_livro]) ?>">
                            <?= Html::img($livro->capa, ['id'=> 'imgCapa'])?>
                        </a>
                    </div>
                    <div class="book-info">
                        <h4><?= Html::encode($livro->titulo)?></h4>
                        <h5><?= Html::encode($livro->genero)?></h5>
                        <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                        <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                    </div>
                    <?= Html::a('VER', ['livros/detalhes', 'id' => $livro->id_livro])?>
                </div>
            <?php }
        }?>


</div>
