<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $livro  */
/* @var $comentarios  */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\frontend\assets\ViewsAssets::register($this);

$this->title = "Detalhes do Livro";
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <section class="col-xs-12">
            <div class="col-xs-12 col-md-5 col-lg-6">
                <div class="capa-livro">
                    <?= Html::img($livro->capa, ['id'=> 'imgCapa', 'style' => 'width: 149%']) ?>
                </div>
            </div>

            <div class="col-xs-12 col-md-7 col-lg-6 livro-info">
                <h1><?= Html::encode($livro->titulo)?></h1>
                <h3>de <?= Html::encode($livro->autor->nome_autor) ?></h3>
                <div class="livro-info-detail">
                    <span><b>Edição: </b><?= Html::encode($livro->ano)?> |
                        <b>ISBN: </b><?= Html::encode($livro->isbn)?> |
                        <b>Formato: </b><?= Html::encode($livro->formato)?> |
                        <b>Biblioteca: </b><?= Html::encode($livro->biblioteca->nome)?> -
                        <a id="maisDetalhes">mais detalhes deste livro</a></span>
                </div>
                <div class="rating">
                    <span class="glyphicon glyphicon-star star-filed" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star-empty"></span><span> 4/5</span>
                </div>
                <div class="actions" style="display: flex;">
                    <div class="btnAction"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                    <div class="btnAction" style="background-color: #c9302c; margin-left: 2%"><?= Html::a('', ['favorito/create', 'id' => $livro->id_livro], ['class' =>"glyphicon glyphicon-heart"])?></div>
                </div>
                <div class="sinopse-content">
                    <h4>SINOPSE</h4>
                    <?php if($livro->sinopse != null) {
                        if (strlen($livro->sinopse) > 400){
                            $sinopse = substr($livro->sinopse, 0, 800) . '...' ?>
                            <span><?= Html::encode($sinopse) ?> (<?= Html::a('mostrar mais') ?>)</span>

                        <?php }?>
                    <?php } else { ?>
                        <p>Sinopse Indisponível</p>
                    <?php }?>
                </div>
            </div>
        </section>
    </div>

    <div class="row">
        <section class="col-lg-12">

            <div class="col-xs-12 col-md-7 col-lg-6 comentarios">
                <div class="commentSection">
                    <?= Html::img(Yii::$app->user->id) //TODO: no model fazer getUtilizador para ir buscar a foto de perfil do user loggado?>
                    <?php $form = ActiveForm::begin(['action' => '../comentario/create?id=' . $livro->id_livro]); ?>
                    <?= $form->field($model, 'comentario')->textarea(['placeholder' => 'Escreva um comentário!', ]); ?>
                    <?= Html::submitButton('Comentar', ['name' => 'comentario', 'class' => 'btnComment']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <hr>
                <div class="commentsArea">
                    <h4><?= sizeof($comentarios)?> comentário(s)</h4>

                    <?php if($comentarios != null){ ?>
                        <?php foreach ($comentarios as $comentario){ ?>
                            <div class="comentario" style="margin-top: 2%">
                                <div class="">
                                    <span><?= Html::img($comentario->utilizador->foto_perfil, ['class' => 'imgPerfil'])?>
                                        <?= Html::a($comentario->utilizador->primeiro_nome . ' ' .$comentario->utilizador->ultimo_nome) ?></span>
                                    <p><?= $comentario->comentario ?></p>
                                    <i><?= $comentario->dta_comentario ?></i>
                                    <span class="commentActions">
                                    <?php if($comentario->id_utilizador == Yii::$app->user->id){ //TODO:alterar pela rule do RBAC ?>
                                        <?= Html::a('', ['comentario/update', 'id' => $comentario->id_comentario], ['class' => 'glyphicon glyphicon-edit', 'style' => 'cursor: pointer'])?>
                                        <?= Html::a('', ['comentario/delete', 'id' => $comentario->id_comentario],
                                            ['data' => ['method' => 'post', 'confirm' =>'Tem a certeza que quer eliminar o comentário?'],
                                                'class' => 'glyphicon glyphicon-remove', 'style' => 'cursor: pointer'])?>
                                    <?php }?>
                                    </span>
                                </div>
                            </div>

                        <?php }

                         if(sizeof($comentarios) > 3) {?>
                        <div class="showMoreComments">
                            <a>Mostar mais</a>
                        </div>
                    <?php }

                    } else { ?>
                        <p>Este livro ainda não tem nenhum comentário. Seja o primeiro a comentar!</p>
                    <?php }?>
                </div>
            </div>

            <div class="col-xs-12 col-md-7 col-lg-6 bookDetails" style="margin-top: 2%; padding: 3%">
                <h4>DETALHES DO LIVRO</h4>
                <div style="margin-top: 7%">
                    <h4><?= Html::encode($livro->titulo)?></h4>
                    <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                </div>
                <div style="margin-top: 4%; background-color: #e5e5e5">
                    <div class="col-xs-12 col-lg-4">
                        <p><?= Html::img($livro->capa, ['style' => 'width: 155px;'])?></p>
                    </div>
                    <div class="col-xs-12 col-lg-8">
                        <p><b>Edição: </b><?= Html::encode($livro->ano)?></p>
                        <p><b>Páginas: </b><?= Html::encode($livro->paginas)?></p>
                        <p><b>Formato: </b><?= Html::encode($livro->formato)?></p>
                        <p><b>Idioma: </b><?= Html::encode($livro->idioma)?></p>
                        <p><b>Editora: </b><?= Html::encode($livro->editora->designacao)?></p>
                        <p><b>Genero: </b><?= Html::encode($livro->genero)?>
                        <p><b>ISBN: </b><?= Html::encode($livro->isbn)?></p>
                        <p><b>Biblioteca: </b><?= Html::encode($livro->biblioteca->nome)?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>