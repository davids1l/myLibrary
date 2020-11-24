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
            <div class="col-xs-12 col-md-5 col-lg-5">
                <div class="capa-livro">
                    <?= Html::img($livro->capa, ['id'=> 'imgCapa']) ?>
                </div>
            </div>

            <div class="col-xs-12 col-md-7 col-lg-7 livro-info">
                <h1><?= Html::encode($livro->titulo)?></h1>
                <h2></h2>
                <h3>de <?= Html::encode($livro->autor->nome_autor) ?></h3>
                <div class="livro-info-detail">
                    <span style="font-weight: bold">Edição: </span><span><?= Html::encode($livro->ano)?> | </span>
                    <span style="font-weight: bold">ISBN: </span><span><?= Html::encode($livro->isbn)?> | </span>
                    <span style="font-weight: bold">Formato: </span><span><?= Html::encode($livro->formato)?> | </span>
                    <span style="font-weight: bold">Páginas: </span><span><?= Html::encode($livro->paginas)?> | </span>
                    <span style="font-weight: bold">Biblioteca: </span><span><?= Html::encode($livro->biblioteca->nome)?></span>
                </div>
                <div class="rating">
                    <span class="glyphicon glyphicon-star star-filed" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star" style="color: darkorange"></span>
                    <span class="glyphicon glyphicon-star-empty"></span><span> 4/5</span>
                </div>
                <div class="actions">
                    <div class="btn"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                    <div class="btn" style="background-color: #c9302c"><?= Html::a('', ['favorito/create', 'id' => $livro->id_livro], ['class' =>"glyphicon glyphicon-heart"])?></div>
                </div>
                <div class="sinopse-content">
                    <h4>SINOPSE</h4>
                    <?php if($livro->sinopse != null) {?>
                        <p><?= $livro->sinopse ?></p>
                        <?php } else { ?>
                            <p>Sinopse Indisponível</p>
                    <?php }?>
                </div>
            </div>
        </section>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-7 col-lg-12 comentarios">
            <h4>COMENTÁRIOS</h4>
            <hr>
            <div class="commentSection">
                <?php $form = ActiveForm::begin(['action' => '../comentario/create?id=' . $livro->id_livro]); ?>
                <?= $form->field($model, 'comentario')->textarea(); ?>
                <?= Html::submitButton('Comentar', ['name' => 'comentario', 'class' => 'btnComment']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="commentsArea">
            <?php if($comentarios != null){ ?>
                <?php foreach ($comentarios as $comentario){ ?>

                    <div class="comentario" style="margin-top: 2%">
                        <div class="">
                            <span><img src="<?= $livro->capa?>" class="imgPerfil"> <a href="#">Nome do Utilizador</a></span>
                            <p><?= $comentario->comentario ?></p>
                            <i><?= $comentario->dta_comentario ?></i>
                            <span class="commentActions">
                            <?php if($comentario->id_utilizador == 2){ //Isto é efetuado pelo ACF e RBAC?>
                                <?= Html::a('', ['comentario/update', 'id' => $comentario->id_comentario], ['class' => 'glyphicon glyphicon-edit', 'style' => 'cursor: pointer'])?>
                                <?= Html::a('', ['comentario/delete', 'id' => $comentario->id_comentario], ['class' => 'glyphicon glyphicon-remove', 'style' => 'cursor: pointer'])?>
                            <?php }?>
                            </span>
                        </div>
                    </div>
                    <?php if(sizeof($comentarios) > 3) {?>
                    <div class="showMore" style="">
                        <a>Mostar mais</a>
                    </div>
                    <?php }?>
                <?php } ?>
            <?php } else { ?>
                <p>Este livro ainda não tem nenhum comentário. Seja o primeiro a comentar!</p>
            <?php }?>
            </div>
        </div>
    </div>
</div>