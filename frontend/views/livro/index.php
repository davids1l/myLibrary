<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LivroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Livros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="livro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Livro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_livro',
            'titulo',
            'isbn',
            'ano',
            'paginas',
            'genero',
            'idioma',
            'formato',
            'capa',
            'sinopse:ntext',
            'id_editora',
            'id_biblioteca',
            'id_autor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
