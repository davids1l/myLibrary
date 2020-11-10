<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


use yii\helpers\Html;
use yii\widgets\LinkPager;

\frontend\assets\AppAsset::register($this);

$this->title = "Detalhes do Livro";
//$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="container">
        <div class="row">
            <section class="col-xs-12">
                <div class="col-xs-12 col-md-5 col-lg-4">
                    <div class="capa-livro">
                        <a href="#">
                            <img src="<?= $livro->capa ?>">
                        </a>
                    </div>
                </div>

                <div class="col-xs-12 col-md-7 col-lg-8 livro-info">
                    <h1><?= Html::encode($livro->titulo)?></h1>
                    <h2></h2>
                    <h3>de <?= Html::encode($livro->autor->nome_autor) ?></h3>
                    <div class="livro-info-detail">
                        <span style="font-weight: bold">Edição: </span><span><?= Html::encode($livro->ano)?> | </span>
                        <span style="font-weight: bold">ISBN: </span><span><?= Html::encode($livro->isbn)?> | </span>
                        <span style="font-weight: bold">Formato: </span><span><?= Html::encode($livro->formato)?> | </span>
                        <span style="font-weight: bold">Páginas: </span><span><?= Html::encode($livro->paginas)?></span>
                    </div>
                    <div class="rating">
                        <span class="glyphicon glyphicon-star star-filed" style="color: darkorange"></span>
                        <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                        <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                        <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </div>
                    <div class="sinopse-content" style="margin-top: 26%">
                        <h4>SINOPSE</h4>
                        <p><?= $livro->sinopse ?></p>
                    </div>
                </div>
            </section>
        </div>
    </div>