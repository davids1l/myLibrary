<?php

use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Requisição #' . $model->id_requisicao;
//$this->params['breadcrumbs'][] = ['label' => 'Requisicaos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="requisicao-view">

    <a class="btnRequisicoes" style="color: #f26b3b" href="<?= Url::to(['requisicao/index']) ?>"><span class="fas fa-arrow-left" style="margin-right: 3px"></span> Requisições</a>
    <h1 class="topicos" style="text-transform: uppercase; padding-left: 0"><?= Html::encode($this->title) ?></h1>
    <hr>

    <h3 style="font-size: 20px">Livro(s) requisitados:</h3>


    <?php
    $livros = RequisicaoLivro::find()->where(['id_requisicao' => $model->id_requisicao])->all();
    foreach ($livros as $livro) {
        $detalhes = Livro::find()->where(['id_livro' => $livro->id_livro])->one(); ?>

    <div class="col-xs-12 col-md-2 col-lg-2 catalogo-grid">
        <div class="capa">
            <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $detalhes->capa, ['id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;'])?>
            </a>
        </div>
        <div class="book-info">
            <h4><?= Html::encode($detalhes->titulo)?></h4>
            <h5>de <?= Html::encode($detalhes->autor->nome_autor)?></h5>
        </div>
    </div>
    <?php } ?>
</div>
