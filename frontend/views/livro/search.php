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
        <div class="" style="display: flex;">
            <div class="col-md-11">
                <?php $form = ActiveForm::begin(['id'=>'pesquisa-form', 'options' => ['class' => 'form-horizontal'], 'action'=>['livro/procurar']]); ?>
                <?= $form->field($model, 'titulo')->textInput(['placeholder'=>'Pesquisar'])->label('')?>
            </div>
            <div class="col-md-1 btnProcurar">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-info']) ?>
                <!-- <?php ActiveForm::end(); ?> -->
            </div>
        </div>
        <div class="pesquisaDetalhada">
            <?= Html::a('Filtros de Pesquisa')?> <!-- , ['url' => ''], ['style' => 'cursor: pointer'] -->
        </div>
        <div class="filtros-pesquisa" style="background-color: whitesmoke; padding: 8px; border-radius: 8px; display: none;"> <!--  -->
            <?= Html::beginForm(['favorito/index'], 'post')?>
            <!-- <?= Html::dropDownList('listar', null, ['Selecione o gênero..', 'Romance', 'Poesia', 'Biografia', 'Aventura', 'Drama', 'Conto', 'Infantil'],
                ['class' => '', 'style' => 'height: 25px !important; width: 250px;']) ?>
            <?= Html::dropDownList('listar', null, ['0'=>'Selecione a edição..', '1' => 'Mais recentes primeiro', '2' => 'Mais antigos primeiro'],
                ['class' => 'dropdown', 'style' => 'height: 25px !important; width: 250px;']) ?> -->

            <div style="display: flex">
                <div class="col-md-6">
                    <?= $form->field($model, 'formato')->dropDownList(['Selecione o formato..','Físico', 'Ebook'])?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'genero')->dropDownList($generos,
                        ['prompt'=>'Selecione o gênero...'])?>
                </div>
            </div>

            <!-- <?= Html::submitButton('Procurar', ['class' => 'btnProcurarFiltros']) ?> -->
            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="catalogo-livros" style="margin-bottom: 2%;">
        <div class="searchResults">
            <div class="col-md-12 livros-titulo">
                <?php if ($livros != null) { ?>
                    <h3>TÍTULOS(S) ENCONTRADOS</h3>
                    <?php foreach ($livros as $livro) { ?>
                        <div class="col-xs-12 col-md-2 catalogo-grid">
                            <div class="capa">
                                <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                                    <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, ['id' => 'imgCapa']) ?>
                                </a>
                            </div>
                            <div class="book-info">
                                <h4><?= Html::encode($livro->titulo) ?></h4>
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
                            <?= Html::a('VER', ['livro/detalhes', 'id' => $livro->id_livro]) ?>
                        </div>
                    <?php }
                } ?>
            </div>


            <div class="col-md-12 livros-atores">
                <?php if ($livrosAutor != null) { ?>
                    <h3>LIVROS DE AUTORES ENCONTRADOS</h3>
                    <?php foreach ($livrosAutor as $livroAut) { ?>
                        <div class="col-xs-12 col-md-2 catalogo-grid">
                            <div class="capa">
                                <a href="<?= Url::to(['livro/detalhes', 'id' => $livroAut->id_livro]) ?>">
                                    <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livroAut->capa, ['id' => 'imgCapa']) ?>
                                </a>
                            </div>
                            <div class="book-info">
                                <h4><?= Html::encode($livroAut->titulo) ?></h4>
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
                            <?= Html::a('VER', ['livro/detalhes', 'id' => $livroAut->id_livro]) ?>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
</div>