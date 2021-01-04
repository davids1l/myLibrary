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

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>


    <div class="listaFavoritos">
        <?php
        if ($livros != null) { ?>

            <div class="col-xs-12 col-md-12 col-lg-12 searchBar" style="margin-bottom: 2%">
                <!-- <?php $form = ActiveForm::begin(['id' => 'listar-form', 'action' => ['favorito/']]); ?>
                <?= $form->field($searchModel, 'dta_favorito')->label('Listar')->dropDownList(['0'=>'Nenhum..', '1' => 'Mais recentes primeiro', '2' => 'Mais antigos primeiro']) ?>
                <?= Html::submitButton('Listar', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?> -->

                <div class="dropdown">
                    <?= Html::beginForm(['favorito/index'], 'post')?>
                        <?= Html::dropDownList('listar', null, ['0'=>'Selecione..', '1' => 'Mais recentes primeiro', '2' => 'Mais antigos primeiro'], ['class' => 'dropdown', 'style' => 'height: 25px !important; width: 250px;']) ?>
                        <?= Html::submitButton('Listar', ['class' => '']) ?>
                    <?= Html::endForm() ?>
                </div>
            </div>

            <?php foreach ($livros as $fav) { ?>
                <div class="col-xs-12 col-md-12 col-lg-12 livroField">
                    <div class="capa-livro-requisicao col-xs-4 col-md-1 col-lg-1">
                        <a href="<?= Url::to(['livro/detalhes', 'id' => $fav->livro->id_livro]) ?>">
                            <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $fav->livro->capa, ['class' => 'capaLivroFinalizar']) ?>
                        </a>
                    </div>
                    <div class="detalhes-livro-requisicao col-xs-6 col-md-10 col-lg-10">
                        <a href="<?= Url::to(['livro/detalhes', 'id' => $fav->livro->id_livro]) ?>">
                            <h4><?= Html::encode($fav->livro->titulo) ?></h4>
                        </a>
                        <h5>de <?= Html::encode($fav->livro->autor->nome_autor) ?></h5>
                        <h6>Edição: <?= Html::encode($fav->livro->ano) ?></h6>
                    </div>
                    <div class="col-xs-2 col-md-1 col-lg-1">
                        <?= Html::a(null, ['favorito/delete', 'id' => $fav->id_favorito], ['data' => ['confirm' => 'Tem a certeza que quer excluir este livro dos seus favoritos?', 'method' => 'post'],
                            'class' => 'glyphicon glyphicon-heart favoritoAction']) ?>
                    </div>
                </div>
            <?php } ?>

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