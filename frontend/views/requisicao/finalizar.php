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

        if ($carrinhoSession != null) {
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
                        <?= Html::a(null, ['carrinho/remover', 'id_livro' => $livro->id_livro], ['data' => ['confirm' => 'Tem a certeza que quer excluir este livro?'],
                            'class' => 'glyphicon glyphicon-remove', 'style' => 'cursor: pointer']) ?>
                    </div>
                </div>
            <?php } ?>

            <div class="detalhesRequisicao">
                <?php $form = ActiveForm::begin(['action' => ['requisicao/create']]) ?>
                <div class="">
                    <div class="col-xs-12">
                        <hr>
                        <?= $form->field($model, 'id_bib_levantamento')->label('Bib. de levantamento')->dropDownList($bibliotecas) ?>
                    </div>
                    <div class="col-xs-12">
                        <?= Html::submitButton('Finalizar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        <?php } else { ?>
            <h3>Carrinho vazio.</h3>
        <?php } ?>
    </div>
</div>