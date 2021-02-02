<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FavoritoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\ViewsAssets::register($this);

$this->title = 'Meus favoritos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favorito-index">

    <h1 style="font-family: 'Yu Gothic UI Light'"><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class="listaFavoritos">
        <?php
        if ($livros != null) { ?>

            <div class="searchBar" style="margin-bottom: 2%">
                <!--<div>
                    <?php $form = ActiveForm::begin(['id' => 'listar-form', 'action' => ['favorito/']]); ?>
                    <?= $form->field($searchModel, 'dta_favorito')->label('Listar')->dropDownList(['1' => 'Mais antigos primeiro', '2' => 'Mais recentes primeiro']) ?>
                    <?= Html::submitButton('Listar', ['class' => 'btn btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>-->

                <div class="filter">
                    <?= Html::beginForm(['favorito/index'], 'post', ['id'=>'listarFavoritos'])?>
                        <?php if (Yii::$app->session->get('favoritoList') == 2) {?>
                            <?= Html::dropDownList('listar', null, ['2' => 'Mais antigos primeiro', '1' => 'Mais recentes primeiro'],
                                ['class' => 'dropdown-listar']) ?>
                        <?php } else { ?>
                            <?= Html::dropDownList('listar', null, ['1' => 'Mais recentes primeiro', '2' => 'Mais antigos primeiro'],
                                ['class' => 'dropdown-listar']) ?>
                        <?php } ?>
                        <!-- <?= Html::submitButton('Listar', ['class' => '']) ?> -->

                    <?= Html::endForm() ?>
                </div>
            </div>

            <div class="row">
                <?php foreach ($livros as $fav) { ?>
                    <div class="col-md-4 livroField" style="background-color: #fafafa">
                        <div class="capa-livro-requisicao col-xs-4 col-md-3">
                            <a href="<?= Url::to(['livro/detalhes', 'id' => $fav->livro->id_livro]) ?>">
                                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $fav->livro->capa, ['class' => 'capaLivroFinalizar', 'style' => 'position: absolute; width: 80px; height: 110px;']) ?>
                            </a>
                        </div>
                        <div class="detalhes-livro-requisicao col-xs-6 col-md-7">
                            <a href="<?= Url::to(['livro/detalhes', 'id' => $fav->livro->id_livro]) ?>">
                                <p style="color: #363434; font-size: 16px; font-family: 'Yu Gothic UI Semibold'"><?= Html::encode($fav->livro->titulo) ?></p>
                            </a>
                            <h5>de <?= Html::encode($fav->livro->autor->nome_autor) ?></h5>
                            <h6>Edição: <?= Html::encode($fav->livro->ano) ?></h6>
                        </div>
                        <div class="col-xs-2 col-md-1">
                            <?= Html::a('<i class="material-icons md-38">remove_circle</i>', ['favorito/delete', 'id' => $fav->id_favorito], ['data' => ['confirm' => 'Tem a certeza que quer excluir este livro dos seus favoritos?', 'method' => 'post'],
                                'class' => 'favoritoAction']) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>


            <div class="pagination">
                <?php
                echo LinkPager::widget([
                    'pagination' => $paginacao,
                ]);
                ?>
            </div>

        <?php } else { ?>
            <?= Html::encode('Não existem livros na sua lista de favoritos.'); ?>
        <?php } ?>
    </div>
</div>