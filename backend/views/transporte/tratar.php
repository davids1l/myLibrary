<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transporte #'.$transporte->id_transporte;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transporte-tratar">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <h4 style="font-family: 'Yu Gothic UI Light';"><?= Html::encode('LIVROS A PREPARAR') ?></h4>
    <hr>


    <div class="col-xs-12 col-md-12"
         style="background-color: whitesmoke; border: 1px solid #ced4da; border-radius: 2px; padding: 20px;">
        <?php foreach ($livrosTransporte as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid"
                 style="max-height: 280px; width: 150px; border: 1px solid #ced4da; border-radius: 2px; padding: 5px; margin-right: 2%;">
                <div class="capa">
                    <a href="<?php //Url::to(['/livros/view', 'id' => $livro[0]['id_livro']])?>">
                        <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, [
                            'id' => 'imgCapa',
                            'style' => 'width: 138px; height: 180px'
                        ]) ?>
                    </a>
                </div>
                <div>
                    <h4><?= $livro->titulo ?></h4>
                    <p>de <?= $livro->autor->nome_autor ?></p>
                </div>
            </div>
        <?php } ?>
    </div>


    <div class="col-md-12" style="margin-top: 15px; padding-left: 0">
        <div class="">
            <?= Html::a('Expedir Transporte', ['transporte/update', 'id' => $transporte->id_transporte], ['class' => 'btn btn-success tratarTransporte']); ?>
        </div>
    </div>


</div>