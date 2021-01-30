<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $livros app\controllers\LivrosController */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

\frontend\assets\ViewsAssets::register($this);

$this->title = "Catálogo de Livros";

//$this->params['breadcrumbs'][] = $this->title;
/*<h1><?= Html::encode($this->title)?></h1><hr>*/
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
            </div>
        </div>
        <div class="pesquisaDetalhada">
            <a href="#" id="pesquisaAvancada" class="pesquisaAvancada" data-content="toggle-text">Filtros de pesquisa
                <i id="mostrarFiltrosPesquisa" class="fa fa-caret-down"></i></a>
        </div>
        <div class="filtros-pesquisa" style="background-color: whitesmoke; padding: 8px; border-radius: 8px; margin-top: 1%;"> <!-- display: none; -->
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

    <div class="catalogo-livros">
        <hr>
        <div class="catalogo">
            <!-- <h3>CATÁLOGO</h3> -->
            <?php if($catalogo != null) { ?>
                <?php foreach ($catalogo as $livro) { ?>
                    <div class="col-xs-12 col-md-2 col-lg-2 catalogo-grid">
                        <div class="capa">
                            <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, ['id' => 'imgCapa', 'style' => 'width: 160px; height: 240px;'])?>
                            </a>
                        </div>
                        <div class="book-info">
                            <h4><?= Html::encode($livro->titulo)?></h4>
                            <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                            <h6><?= Html::encode($livro->genero) ?></h6>
                            <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                            <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                            <?php
                            if($this->context->verificarEmRequisicao($livro->id_livro) == true){ ?>
                                <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                            <?php } else { ?>
                                <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                            <?php } ?>
                        </div>
                    </div>
                <?php }
            } else {?>
                <p>Não existem favoritos.</p>
            <?php }?>
        </div>
    </div>
</div>

