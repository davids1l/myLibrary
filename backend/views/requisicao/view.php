<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Fatura requisição: '. $model->id_requisicao;
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="requisicao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="background-color: #eaeaea;">
            <h3>Requisição: #<?= $model->id_requisicao ?>  </h3>
            <br>
            <p><b>Nome:</b> <?= $model->utilizador->primeiro_nome . " " . $model->utilizador->ultimo_nome ?>  </p>
            <p><b>NIF:</b> <?= $model->utilizador->nif ?> </p>
            <p><b>Telemóvel:</b> <?= $model->utilizador->num_telemovel ?> </p>
            <p><b>Biblioteca:</b> <?= $model->bibLevantamento->nome ?> </p>
            <p><b>Data de levantamento:</b> <?= $model->dta_levantamento ?> </p>
            <p><b>Data de entrega:</b> <?= $model->dta_entrega ?> </p>
            <br>
            <h3>Livros requisitados: </h3>
            <br>
            <?php foreach($livros as $livro) { ?>
                <div class="col-xs-12 col-md-2 catalogo-grid" style="">
                    <div class="capa">
                        <a href="<?php //Url::to(['/livros/view', 'id' => $livro[0]['id_livro']])?>">
                            <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro[0]->capa, [
                                'id' => 'imgCapa',
                                'style' => 'width: 70px; height: 100px'
                            ])?>
                        </a>
                    </div>
                    <h4><b><?= $livro[0]['titulo'] ?></b></h4>
                    <p>de <?= $livro[0]->autor->nome_autor ?></p>
                    <br>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-2"></div>
    </div>

</div>
