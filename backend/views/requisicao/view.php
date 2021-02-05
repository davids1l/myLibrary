<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Fatura requisição: #' . $model->id_requisicao;
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="requisicao-view">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="background-color: whitesmoke; border: 1px solid grey; border-radius: 2px;">
            <h3 class="topicos">Requisição: #<?= $model->id_requisicao ?>  </h3>
            <br>
            <p>
                <b>Nome:</b> <?= $model->utilizador->primeiro_nome . " " . $model->utilizador->ultimo_nome . " (" . $model->utilizador->numero . ")" ?>
            </p>
            <p><b>NIF:</b> <?= $model->utilizador->nif ?> </p>
            <p><b>Telemóvel:</b> <?= $model->utilizador->num_telemovel ?> </p>
            <p><b>Biblioteca:</b> <?= $model->bibLevantamento->nome ?> </p>
            <p><b>Data de levantamento:</b> <?= Carbon::parse($model->dta_levantamento)->format('d/m/Y H:i:s') ?> </p>
            <p><b>Data de entrega:</b> <?= Carbon::parse($model->dta_entrega)->format('d/m/Y H:i:s') ?> </p>
            <br>
            <h3>Livros requisitados: </h3>
            <br>
            <div class="row">
                <div class="col-md-1"></div>
                <?php foreach ($livros as $livro) { ?>
                    <div class="col-xs-12 col-md-2 catalogo-grid text-center">
                        <a href="<?= Url::to(['/livros/view', 'id' => $livro[0]['id_livro']]) ?>" style="text-decoration: none; color: black;">
                            <div class="capa">
                                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro[0]->capa, [
                                    'id' => 'imgCapa',
                                    'style' => 'width: 70px',
                                ]) ?>
                            </div>
                            <h4><b><?= $livro[0]['titulo'] ?></b></h4>
                            <p>de <?= $livro[0]->autor->nome_autor ?></p>
                        </a>

                        <br>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

</div>
