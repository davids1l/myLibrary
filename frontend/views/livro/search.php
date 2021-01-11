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
    <div class="col-lg-12 searchBar">
        <div>
            <?php $form = ActiveForm::begin(['id'=>'pesquisa-form', 'action'=>['livro/procurar']]); ?>
            <?= $form->field($model, 'titulo')->textInput(['placeholder'=>'Insira o título do livro'])?>
            <?= Html::submitButton('Procurar', ['class' => 'btn btn-info']) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div>

        </div><hr>
    </div>

    <div class="catalogo-livros" style="margin-bottom: 2%;">
        <div class="col-lg-12 searchResults">
            <?php if($results != null) { ?>
                <h3>RESULTADO(S) DA PESQUISA</h3>
                <?php foreach ($results as $result) { ?>
                    <div class="col-xs-12 col-md-2 catalogo-grid">
                        <div class="capa">
                            <a href="<?= Url::to(['livro/detalhes', 'id' => $result->id_livro]) ?>">
                                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $result->capa, [
                                    'id' => 'imgCapa'
                                ])?>
                            </a>
                        </div>
                        <div class="book-info">
                            <h4><?= Html::encode($result->titulo)?></h4>
                            <h5><?= Html::encode($result->genero)?></h5>
                            <h6>Idioma: <?= Html::encode($result->idioma)?></h6>
                            <h6>Formato: <?= Html::encode($result->formato)?></h6>
                            <?php
                            if($this->context->verificarEmRequisicao($result->id_livro) == true){ ?>
                                <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                            <?php } else { ?>
                                <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                            <?php } ?>
                        </div>
                        <?= Html::a('VER', ['livro/detalhes', 'id' => $result->id_livro])?>
                    </div>
                <?php }
            } else {?>
                <p>Não foram encontrados resultados para a pesquisa.</p>
            <?php }?>
        </div>
    </div>

</div>