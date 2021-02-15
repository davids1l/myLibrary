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

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="rowAddBook">
        <div class="row" style="display: flex; justify-content: center; align-items: center;">
            <div class="col-md-7">
                <?php $form = ActiveForm::begin([
                    'id' => 'pesquisa-form',
                    'options' => ['class' => 'form-horizontal'],
                    'action' => ['requisicao/create']
                ]) ?>

                <?= $form->field($searchModel, 'titulo')->label('Indique o título a pesquisar: '); ?>
            </div>
            <div class="col-md-5" style="display: flex; justify-content: left; align-items: center;">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Pesquisar', ['className' => 'pesquisa', 'class' => 'btnAcao']); ?>
                <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar todos', ['requisicao/create'], [
                    'class' => 'btnAcao',
                    'style' => 'margin-left: 5px;'
                ]); ?>

                <?php ActiveForm::end() ?>
                <br/>
            </div>
        </div>
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-8" style="overflow-y: scroll; height:400px;">
                <div class="row">
                    <?php if ($allLivros != null) { ?>
                        <?php foreach ($allLivros as $livro) { ?>
                            <div class="col-md-2 catalogo-grid gridLivros text-center"
                                 style="height: 280px; margin: 10px">
                                <div class="capa" style="margin: 10px">
                                    <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                                        <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livro->capa, [
                                            'id' => 'imgCapa',
                                            'style' => 'height: 100px; width: auto;'
                                        ]) ?>
                                    </a>
                                </div>
                                <div class="book-info">
                                    <h4><?= Html::encode($livro->titulo) ?></h4>
                                    <h5><?= Html::encode($livro->genero) ?></h5>
                                    <h6>Idioma: <?= Html::encode($livro->idioma) ?></h6>
                                    <h6>Formato: <?= Html::encode($livro->formato) ?></h6>
                                </div>

                                <?= Html::a('<span class="glyphicon glyphicon-shopping-cart"></span>', ['carrinho/adicionar', 'id_livro' => $livro->id_livro], [
                                    'class' => 'btn book-buttons', 'style' => 'color: black'
                                ]) ?>
                            </div>

                        <?php } ?>
                    <?php } else { ?>
                        <br/>
                        <p>Parece que não foram encontrados livros.</p>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-4">
                <h3>Carrinho: </h3>
                <?php if ($carrinhoSession != null) { ?>
                    <?php foreach ($carrinhoSession as $carrinhoLivro) { ?>
                        <div class="livrosCarrinho">
                            <div class="row">
                                <div class="col-md-7 livro-info"
                                     style="display: flex; justify-content: left; align-items: center;">
                                    <h4 style="font-size: medium"><?= Html::encode($carrinhoLivro->titulo) ?></h4>
                                </div>

                                <div class="col-md-2">
                                    <?= Html::a('<span class="glyphicon glyphicon-shopping-cart"></span>', ['carrinho/remover', 'id_livro' => $carrinhoLivro->id_livro], [
                                        'class' => 'btn btn-danger book-buttons',
                                        'style' => 'inline-block'
                                    ]) ?>
                                </div>

                            </div>

                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>Carrinho vazio.</p>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <?= Html::submitButton('Concluir', ['class' => 'btnAcao', 'style' => 'margin-left: 70%']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
