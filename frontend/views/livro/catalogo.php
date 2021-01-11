
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
/*<h1><?= Html::encode($this->title)?></h1><hr>

<?= $form->field($model, 'formato')->dropDownList(['Nenhum','Físico', 'Ebook'])?>*/
?>
<div class="container">
    <div class="col-xs-12 col-md-12 col-lg-12 searchBar">
        <div>
            <?php $form = ActiveForm::begin(['id'=>'pesquisa-form', 'action'=>['livro/procurar']]); ?>
            <?= $form->field($model, 'titulo')->textInput(['placeholder'=>'Insira o título do livro'])?>
            <?= Html::submitButton('Procurar', ['class' => 'btn btn-info']) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div>

        </div><hr>
    </div>

    <div class="catalogo-livros">
        <div class="col-md-6 col-lg-12 novos">
            <h3>NOVOS LANÇAMENTOS</h3>
            <?php if($recentes != null) {?>
                <?php foreach ($recentes as $recente){ ?>
                    <div class="col-xs-12 col-md-2 catalogo-grid">
                        <div class="capa">
                            <a href="<?= Url::to(['detalhes', 'id' => $recente->id_livro])?>">
                                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $recente->capa, [
                                    'id' => 'imgCapa'
                                ])?>
                            </a>
                        </div>
                        <div class="book-info">
                            <h4><?= Html::encode($recente->titulo)?></h4>
                            <h5><?= Html::encode($recente->genero)?></h5>
                            <h6>Idioma: <?= Html::encode($recente->idioma)?></h6>
                            <h6>Formato: <?= Html::encode($recente->formato)?></h6>
                            <?php
                            if($this->context->verificarEmRequisicao($recente->id_livro) == true){ ?>
                                <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                            <?php } else { ?>
                                <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                            <?php } ?>
                        </div>
                        <?= Html::a('VER', ['livro/detalhes', 'id' => $recente->id_livro])?>
                    </div>
                <?php }
            } else {?>
                <p>Não existem livros.</p>
            <?php }?>
        </div>

        <div class="col-lg-12 maisRequisitados">
            <h3>MAIS REQUISITADOS</h3>
            <?php if($maisRequisitados != null) { ?>
                <?php foreach ($maisRequisitados as $livro) { ?>
                    <div class="col-xs-12 col-md-2 catalogo-grid">
                        <div class="capa">
                            <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                                <?= Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, [
                                    'id' => 'imgCapa'
                                ])?>
                            </a>
                        </div>
                        <div class="book-info">
                            <h4><?= Html::encode($livro->titulo)?></h4>
                            <h5><?= Html::encode($livro->genero)?></h5>
                            <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                            <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                            <?php
                            if($this->context->verificarEmRequisicao($livro->id_livro) == true){ ?>
                                <h6>Disponível:<b style="color: #3c763d" class="glyphicon glyphicon-ok"></b></h6>
                            <?php } else { ?>
                                <h6>Disponível:<b style="color: #c9302c" class="glyphicon glyphicon-remove"></b></h6>
                            <?php } ?>
                        </div>
                        <?= Html::a('VER', ['livro/detalhes', 'id' => $livro->id_livro])?>
                    </div>
                <?php }
            } else {?>
                <p>Não existem livros.</p>
            <?php }?>
        </div>
    </div>
</div>

