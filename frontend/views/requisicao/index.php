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


    <div class="livrosCarrinho">
        <?php
        $carrinhoSession = Yii::$app->session->get('carrinho');

        if (isset($carrinhoSession)) {
            foreach ($carrinhoSession as $livro) { ?>
                <div class="col-xs-12 col-lg-12" style="background-color: #e5e5e5; margin-top: 1%; padding: 1%;">
                    <div class="col-xs-8 col-lg-6">
                        <div class="capa-livro-requisicao col-xs-7 col-lg-2">
                            <?= Html::img($livro->capa, ['style' => 'max-width: 100%']) ?>
                        </div>
                        <div class="detalhes-livro-requisicao cold-xs-1 col-lg-4">
                            <?= Html::encode($livro->titulo) ?>
                            <?= Html::encode($livro->autor->nome_autor) ?>
                            <p>
                                Formato:
                                <?= Html::encode($livro->formato) ?>
                            </p>
                        </div>
                    </div>
                    <div class="actions-livros-carrinho col-xs-4 col-lg-6">
                        <?= Html::a(null, ['remover', 'id_livro' => $livro->id_livro], ['data' => ['confirm' => 'Tem a certeza que quer excluir este livro?'],
                            'class' => 'glyphicon glyphicon-remove', 'style' => 'cursor: pointer']) ?>
                    </div>
                </div>
            <?php } ?>
            <p>
                <!-- <?= Html::a('Finalizar', ['create'], ['class' => 'btn btn-success']) ?> -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#criarRequisicaoModal">Finalizar requisição</button>
            </p>

        <?php } else { ?>
            <h3>Carrinho vazio.</h3>
        <?php } ?>
    </div>
</div>

<!-- Modal para criar leitor -->
<div class="modal fade" id="criarRequisicaoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="exampleModalLabel">Dados requisição</h2>
            </div>
            <?php $form = ActiveForm::begin([
                'action' => ['requisicao/create']]) ?>
            <div class="" style="background-color: white">
                <div class="col-lg-12">
                    <?= $form->field($model, 'dta_levantamento')->label('Data de levantamento')->input('date') ?>
                    <!-- <?= $form->field($model, 'dta_entrega')->label('Data de entrega')->input('date') ?> -->

                    <?php
                    $array = [];
                    foreach ($bibliotecas as $biblioteca) {
                        array_push($array, $biblioteca->nome);
                    }?>

                    <?= $form->field($model, 'id_bib_levantamento')->label('Bib. de levantamento')->dropDownList($array) ?>

                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Finalizar', ['class' => 'btn-perfil']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
