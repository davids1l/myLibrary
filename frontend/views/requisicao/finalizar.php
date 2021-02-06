<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequisicaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\ViewsAssets::register($this);

$this->title = 'Finalizar requisição';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <hr>
    <div class="livrosCarrinho">
        <?php
        $carrinhoSession = Yii::$app->session->get('carrinho');

        if ($carrinhoSession != null) {
            foreach ($carrinhoSession as $livro) { ?>
                <div class="col-xs-12 col-md-12 col-lg-12 livroField" style="background-color: #fafafa">
                    <div class="capa-livro-requisicao col-xs-4 col-md-3">
                        <?= Html::img('/myLibrary/backend/web/imgs/capas/' .$livro->capa, ['class' => 'capaLivroFinalizar', 'style' => 'position: absolute; width: 80px; height: 110px;']) ?>
                    </div>
                    <div class="detalhes-livro-requisicao col-xs-6 col-md-7">
                        <h4><?= Html::encode($livro->titulo) ?></h4>
                        <h5><?= Html::encode($livro->autor->nome_autor) ?></h5>
                        <h6>Edição: <?= Html::encode($livro->ano) ?></h6>
                    </div>
                    <div class="col-xs-2 col-md-1" style="padding-left: 10%;">
                        <?= Html::a('<i class="fas fa-times"></i>', ['carrinho/remover', 'id_livro' => $livro->id_livro], ['data' => ['confirm' => 'Tem a certeza que quer excluir este livro do cesto?'],
                            'class' => 'favoritoAction']) ?>
                    </div>
                </div>
            <?php } ?>

            <div class="detalhesRequisicao">
                <?php $form = ActiveForm::begin(['action' => ['requisicao/create'], 'id' => 'formFinalizar']) ?>
                <div class="">
                    <div class="col-xs-12">
                        <hr>
                        <?= $form->field($model, 'id_bib_levantamento')->label('Bib. de levantamento')->dropDownList($bibliotecas) ?>
                    </div>
                    <div class="col-xs-12">
                        <?= Html::submitButton('Finalizar', ['class' => 'btn btn-success', 'id' => 'finalizarButton', 'value' => 'Finalizar', 'name'=>'finalizarButton']) ?>
                    </div>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        <?php } else { ?>
            <h3>Cesto vazio.</h3>
        <?php } ?>
    </div>
    <div>

    </div>
</div>