<?php

use Carbon\Carbon;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequisicaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requisição #' . $requisicao;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-index">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>
    <br>
    <h4>Livros a preparar: </h4>

    <div class="row" style="margin-top: 20px">
        <?php foreach ($livros as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid text-center">
                <div class="capa">
                    <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro[0]->capa, [
                        'id' => 'imgCapa',
                        'style' => 'width: 150px'
                    ]) ?>
                </div>

                <h4><?= $livro[0]['titulo'] ?></h4>
                <p>de <?= $livro[0]->autor->nome_autor ?></p>
                <br>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <?= Html::a('Finalizar', ['site/preparar', 'id' => $requisicao], ['class' => 'btnAcao', 'data' => ['method' => 'post']]); ?>
        </div>
    </div>
</div>
