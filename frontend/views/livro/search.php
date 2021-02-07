<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $livros app\controllers\LivrosController */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;

\frontend\assets\ViewsAssets::register($this);

$this->title = "Catálogo de Livros";

?>


<div class="container">
    <div class="searchBar">
        <div class="pesquisaSimples" style="display: flex" >
            <div class="col-xs-11 col-md-11 termosPesquisa">
                <?php $form = ActiveForm::begin(['id'=>'pesquisa-form', 'options' => ['class' => 'form-horizontal'], 'action'=>['livro/procurar']]); ?>
                <?= $form->field($model, 'titulo')->textInput(['placeholder'=>'Pesquisar'])->label('')?>
            </div>
            <div class="col-xs-1 col-md-1 btnProcurar">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn', 'style' => 'width: 100%; background-color: #f26b3b; color:white;']) ?>
            </div>
        </div>

        <div class="pesquisaDetalhada">
            <a href="#" id="pesquisaAvancada" class="pesquisaAvancada" data-content="toggle-text">Filtros de pesquisa
                <i id="mostrarFiltrosPesquisa" class="fa fa-caret-down"></i></a>

            <div class="filtros-pesquisa"> <!-- display: none; -->
                <?= Html::beginForm(['favorito/index'], 'post')?>
                <div style="display: flex">
                    <div class="col-md-6">
                        <?= $form->field($model, 'formato')->dropDownList(['Físico', 'Ebook'], ['prompt'=>'Selecione o formato...'])?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'genero')->dropDownList($generos,
                            ['prompt'=>'Selecione o gênero...'])?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>

    <div class="row catalogo-livros" style="margin-bottom: 2%;">
        <hr>
        <?php if($livros == null && $livrosAutor == null) { ?>
            <p>Não foram encontrados resultados para a pesquisa.</p>
        <?php } else { ?>
        <div class="searchResults">
            <div class="col-md-12 livros-titulo" style="padding-left: 0">
                <?php if ($livros != null) { ?>
                    <h3 class="topicos">LIVRO(S) ENCONTRADOS</h3>
                    <?php foreach ($livros as $livro) { ?>
                        <div class="col-xs-12 col-md-2 catalogo-grid">
                            <div class="capa">
                                <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                                    <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, ['id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;']) ?>
                                </a>

                                <?= Html::a('ADICIONAR <i class="fas fa-shopping-basket"></i>', ['carrinho/adicionar', 'id_livro' => $livro->id_livro],
                                    ['class' => "carrinho-overlay", 'id' => 'adicionarCarrinho']) ?>
                            </div>
                            <div class="book-info">
                                <h4><?= Html::encode($livro->titulo) ?></h4>
                                <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                                <h5><?= Html::encode($livro->genero) ?></h5>
                                <h6>Idioma: <?= Html::encode($livro->idioma) ?></h6>
                                <h6>Formato: <?= Html::encode($livro->formato) ?></h6>
                                <?php
                                if ($this->context->verificarEmRequisicao($livro->id_livro) == true) { ?>
                                    <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                                <?php } else { ?>
                                    <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b>
                                    </h6>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>


            <div class="col-md-12 livros-atores"  style="padding-left: 0">
                <?php if ($livrosAutor != null) { ?>
                    <h3 class="topicos">LIVROS DE AUTORES ENCONTRADOS</h3>
                    <?php foreach ($livrosAutor as $livroAut) { ?>
                        <div class="col-xs-12 col-md-2 catalogo-grid">
                            <div class="capa">
                                <a href="<?= Url::to(['livro/detalhes', 'id' => $livroAut->id_livro]) ?>">
                                    <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livroAut->capa, ['id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;']) ?>
                                </a>

                                <?= Html::a('ADICIONAR <i class="fas fa-shopping-basket"></i>', ['carrinho/adicionar', 'id_livro' => $livroAut->id_livro],
                                    ['class' => "carrinho-overlay", 'id' => 'adicionarCarrinho']) ?>
                            </div>
                            <div class="book-info">
                                <h4><?= Html::encode($livroAut->titulo) ?></h4>
                                <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                                <h5><?= Html::encode($livroAut->genero) ?></h5>
                                <h6>Idioma: <?= Html::encode($livroAut->idioma) ?></h6>
                                <h6>Formato: <?= Html::encode($livroAut->formato) ?></h6>
                                <?php
                                if ($this->context->verificarEmRequisicao($livroAut->id_livro) == true) { ?>
                                    <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                                <?php } else { ?>
                                    <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b>
                                    </h6>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>