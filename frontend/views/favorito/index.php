<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FavoritoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\ViewsAssets::register($this);

$this->title = 'Meus favoritos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favorito-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="col-xs-12 col-md-12 col-lg-12 searchBar">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id'=>'pesquisa-form', 'action'=>['favorito/procurar']]); ?>
            <?= $form->field($searchModel, 'dta_favorito')->textInput(['placeholder'=>'Insira o título do livro'])?>
            <?= Html::submitButton('Procurar', ['class' => 'btn btn-info']) ?>
            <?php ActiveForm::end(); ?>
        </div>

    </div>

    <div class="listaFavoritos">
        <?php
        if ($favoritos != null) {
            foreach ($favoritos as $fav) { ?>
                <div class="col-xs-12 col-md-12 col-lg-12 livroField">
                    <div class="capa-livro-requisicao col-xs-4 col-md-1 col-lg-1">
                        <?= Html::img($fav->livro->capa, ['class' => 'capaLivroFinalizar']) ?>
                    </div>
                    <div class="detalhes-livro-requisicao col-xs-6 col-md-10 col-lg-10">
                        <h4><?= Html::encode($fav->livro->titulo) ?></h4>
                        <h5>de <?= Html::encode($fav->livro->autor->nome_autor) ?></h5>
                        <h6>Edição: <?= Html::encode($fav->livro->ano) ?></h6>
                    </div>
                    <div class="col-xs-2 col-md-1 col-lg-1">
                        <?= Html::a(null, ['favorito/delete', 'id' => $fav->id_favorito], ['data' => ['confirm' => 'Tem a certeza que quer excluir este livro dos seus favoritos?', 'method' => 'post'],
                            'class' => 'glyphicon glyphicon-heart favoritoAction']) ?>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
    <div class="requisicao">

    </div>

</div>