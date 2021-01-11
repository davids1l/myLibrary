<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Adicionar Requisição';
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$carrinhoSession = Yii::$app->session->get('carrinho');
?>
<div class="requisicao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rowAddBook">

        <?php $form = ActiveForm::begin([
            'id' => 'pesquisa-form',
            'options' => ['class' => 'form-horizontal'],
            'action' => ['requisicao/create']
        ]) ?>

        <?= $form->field($searchModel, 'titulo')->label('Indique o título a pesquisar: '); ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Pesquisar', ['className' => 'pesquisa', 'class' => 'btn btn-primary']); ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar todos', ['requisicao/create'], [
            'class' => 'btn btn-info'
        ]); ?>

        <?php ActiveForm::end() ?>
        <br/>
        <div class="row">
            <div class="col-md-8" style="overflow-y: scroll; height:400px;">
                <div class="row">
                    <?php $form = ActiveForm::begin(); ?>
                    <?php if($livros != null) { ?>
                        <?php foreach ($livros as $livro) { ?>
                            <?php if($livrosReq != null) { ?>
                                <?php foreach ($livrosReq as $livroReq) { ?>
                                    <?php if($livroReq->id_livro == $livro->id_livro) { ?>
                                        <div class="col-md-4 catalogo-grid gridLivros" style="height: 350px">
                                            <div class="capa">
                                                <a href="<?= Url::to(['livros/view', 'id' => $livroReq->id_livro]) ?>">
                                                    <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livroReq->capa, ['id'=> 'imgCapa'])?>
                                                </a>
                                            </div>
                                            <div class="book-info">
                                                <h4><?= Html::encode($livroReq->titulo)?></h4>
                                                <h5><?= Html::encode($livroReq->genero)?></h5>
                                                <h6>Idioma: <?= Html::encode($livroReq->idioma)?></h6>
                                                <h6>Formato: <?= Html::encode($livroReq->formato)?></h6>
                                            </div>

                                            <?= Html::a('<span class="glyphicon glyphicon-warning-sign"></span> Indisponível', ['carrinho/adicionar', 'id_livro' => $livroReq->id_livro], [
                                                'class' => 'btn btn-warning book-buttons'
                                            ])?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-4 catalogo-grid gridLivros" style="height: 350px">
                                            <div class="capa">
                                                <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                                                    <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livro->capa, ['id'=> 'imgCapa'])?>
                                                </a>
                                            </div>
                                            <div class="book-info">
                                                <h4><?= Html::encode($livro->titulo)?></h4>
                                                <h5><?= Html::encode($livro->genero)?></h5>
                                                <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                                                <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                                            </div>

                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar', ['carrinho/adicionar', 'id_livro' => $livro->id_livro], [
                                                'class' => 'btn btn-success book-buttons'
                                            ])?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($carrinhoSession != null) { ?>
                                <?php foreach ($carrinhoSession as $carrinhoLivro) { ?>
                                    <?php if($carrinhoLivro->id_livro == $livro->id_livro) { ?>
                                        <div class="col-md-4 catalogo-grid gridLivros" style="height: 350px">
                                            <div class="capa">
                                                <a href="<?= Url::to(['livros/view', 'id' => $carrinhoLivro->id_livro]) ?>">
                                                    <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $carrinhoLivro->capa, ['id'=> 'imgCapa'])?>
                                                </a>
                                            </div>
                                            <div class="book-info">
                                                <h4><?= Html::encode($carrinhoLivro->titulo)?></h4>
                                                <h5><?= Html::encode($carrinhoLivro->genero)?></h5>
                                                <h6>Idioma: <?= Html::encode($carrinhoLivro->idioma)?></h6>
                                                <h6>Formato: <?= Html::encode($carrinhoLivro->formato)?></h6>
                                            </div>

                                            <?= Html::a('<span class="glyphicon glyphicon-minus"></span> Remover', ['carrinho/remover', 'id_livro' => $carrinhoLivro->id_livro], [
                                                'class' => 'btn btn-danger book-buttons'
                                            ])?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-4 catalogo-grid gridLivros">
                                            <div class="capa">
                                                <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                                                    <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livro->capa, ['id'=> 'imgCapa'])?>
                                                </a>
                                            </div>
                                            <div class="book-info">
                                                <h4><?= Html::encode($livro->titulo)?></h4>
                                                <h5><?= Html::encode($livro->genero)?></h5>
                                                <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                                                <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                                            </div>

                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Adicionar', ['carrinho/adicionar', 'id_livro' => $livro->id_livro], [
                                                'class' => 'btn btn-success book-buttons'
                                            ])?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <br/>
                        <p>Parece que não foram encontrados livros.</p>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'dta_levantamento')->label('Data de levantamento')->input('datetime-local') ?>
                <?= $form->field($model, 'dta_entrega')->label('Data de entrega')->input('datetime-local') ?>
                <?= $form->field($model, 'estado')->textInput() ?>
                <?= $form->field($model, 'id_utilizador')->dropDownList($utilizadores)->label("Número de telemóvel") ?>
                <?= $form->field($model, 'id_bib_levantamento')->dropDownList($bibliotecas)->label("Biblioteca para levantamento") ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <?= Html::submitButton('Concluir', ['class' => 'btn btn-primary', 'style' => 'margin-left: 70%']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
