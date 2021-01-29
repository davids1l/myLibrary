<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\frontend\assets\ViewsAssets::register($this);

$this->title = "Detalhes do Livro";
//$this->params['breadcrumbs'][] = ['label' => 'Catálogo', 'url' => ['catalogo']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <section class="col-xs-12">
            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="capaDetalhes">
                    <?= Html::img(Yii::$app->request->baseUrl . '/../../backend/web/imgs/capas/' . $livro->capa, [
                        'id' => 'imgCapa'
                    ])?>
                    <div class="overlay">
                        <?php if(!is_null($favorito)){ ?>
                             <a href="<?= Url::to(['favorito/delete', 'id' => $favorito->id_favorito])?>" data-method="POST" class="icon">
                                <i class="fa fa-heart"></i>
                            </a>
                        <?php } else { ?>
                            <a href="<?= Url::to(['favorito/create', 'id' => $livro->id_livro]) ?>" class="icon">
                                <i class="far fa-heart"></i>
                            </a>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-7 col-lg-8 livro-info">
                <h1><?= Html::encode($livro->titulo)?></h1>
                <h3>de <?= Html::encode($livro->autor->nome_autor) ?></h3>
                <div class="livro-info-detail" >
                    <span>
                        <b>Edição: </b><?= Html::encode($livro->ano)?> |
                        <b>ISBN: </b><?= Html::encode($livro->isbn)?> |
                        <b>Formato: </b><?= Html::encode($livro->formato)?> |
                        <b>Biblioteca: </b><?= Html::encode($livro->biblioteca->nome)?> -
                        <a id="maisDetalhes" href="#bookDetails">mais detalhes deste livro</a>
                    </span>
                </div>
                <div class="rating">
                    <!-- <span class="badge"><i class="glyphicon glyphicon-heart" style="color: #c9302c; font-size: 22px"></i><?= $totalFav?></span> -->
                </div>
                <div class="actions">
                    <div class="">
                        <?php if (!is_null($favorito)) { ?>
                            <span class="badge"
                                  style="background-color: #dedede; color: dimgrey;"><?= Html::a('', ['favorito/delete', 'id' => $favorito->id_favorito],
                                    ['data' => ['method' => 'post'], 'class' => "glyphicon glyphicon-heart btnFav"]) ?><?= $totalFav ?></span>
                        <?php } else { ?>
                            <span class="badge"
                                  style="background-color: #dedede; color: dimgrey;"><?= Html::a('', ['favorito/create', 'id' => $livro->id_livro], ['class' => "far fa-heart btnNotFav"]) ?><?= $totalFav ?></span>
                        <?php } ?>
                    </div>
                    <div class="" style="margin-top: 5%">
                        <?= Html::a('ADICIONAR CARRINHO <i class=" glyphicon glyphicon-shopping-cart"></i>', ['carrinho/adicionar', 'id_livro' => $livro->id_livro], ['class' => "", 'id' => 'adicionarCarrinho']) ?> <!-- glyphicon glyphicon-shopping-cart -->
                    </div>
                </div>
                <div class="sinopse-content">
                    <h4>SINOPSE</h4>
                    <?php if($livro->sinopse != null) { ?>
                        <div class="sinopse_more" style="display: none;">
                            <span><?= Html::encode($livro->sinopse)?></span>
                        </div>
                        <div class="sinopse_less">
                            <?php if (strlen($livro->sinopse) > 800){ ?>
                                <span class="sinopse" id="lessSinopse "><?= Html::encode(substr($livro->sinopse, 0, 800) . '...') ?></span>
                            <?php } else { ?>
                                <span class="sinopse" id="lessSinopse "><?= Html::encode($livro->sinopse)?></span>
                            <?php } ?>
                        </div>
                        <a href="#mostrarmais" class="mostrarmais" data-content="toggle-text">Mostrar mais</a>
                    <?php } else { ?>
                        <p><?= Html::encode('Sinopse Indisponível') ?></p>
                    <?php }?>
                </div>
            </div>
        </section>
    </div>

    <div class="row">
        <section>
            <div class="col-xs-12 col-md-7 col-lg-6 comentarios">
                <h4>COMENTÁRIOS</h4>
                <div class="commentSection">
                    <?php $form = ActiveForm::begin(['action' => '../comentario/create?id=' . $livro->id_livro, 'id' => 'formComentar']); ?>
                    <?= $form->field($modelComentario, 'comentario')->textarea(['placeholder' => 'Escreva um comentário!', 'style' => 'resize: none', 'id'=>'comentarioField']); ?>
                    <?= Html::submitButton('Comentar', ['name' => 'comentario', 'class' => 'btnComment', 'id' => 'submitComentario']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <hr>
                <div class="commentsArea">
                    <h4><?= sizeof($comentarios)?> comentário(s)</h4>

                    <?php if($comentarios != null){ ?>
                        <?php foreach ($comentarios as $comentario){ ?>
                            <div class="comentario" style="margin-top: 2%">
                                <div class="">
                                    <span><?= Html::img(Yii::$app->request->baseUrl . '/imgs/perfil/' . $comentario->utilizador->foto_perfil, ['class' => 'imgPerfil'])?>
                                        <?= Html::a($comentario->utilizador->primeiro_nome . ' ' .$comentario->utilizador->ultimo_nome) ?></span>
                                    <p><?= Html::encode($comentario->comentario) ?></p>
                                    <i><?= Carbon::parse(Html::encode($comentario->dta_comentario))->format('d/m/Y H:i:s') ?></i>
                                    <span class="commentActions">
                                    <?php if($comentario->id_utilizador == Yii::$app->user->id || Yii::$app->user->can('admin') || Yii::$app->user->can('bibliotecario')){ ?>
                                        <?= Html::a('', null, ['class' => 'glyphicon glyphicon-edit', 'style' => 'cursor: pointer',
                                           'data-toggle'=>'modal', 'data-target' => "#alterarComentarioModal" ])?>
                                        <?= Html::a('', ['comentario/delete', 'id' => $comentario->id_comentario],
                                            ['data' => ['method' => 'post', 'confirm' =>'Tem a certeza que quer eliminar o comentário?'],
                                                'class' => 'glyphicon glyphicon-remove', 'style' => 'cursor: pointer'])?>
                                    <?php }?>
                                    </span>
                                </div>
                            </div>


                            <!-- Modal para alterar comentário -->
                            <div class="modal fade" id="alterarComentarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h2 class="modal-title" id="exampleModalLabel">Alterar comentário</h2>
                                        </div>
                                        <?php $form = ActiveForm::begin([
                                            'action' => ['comentario/update', 'id' => $comentario->id_comentario]]) ?>
                                        <div class="" style="background-color: white">
                                            <div class="col-lg-12">
                                                <?= $form->field($modelComentario, 'comentario')->label('Novo comentário')->textarea(['placeholder' => 'Escreva o novo comentário..',
                                                    'style' => 'resize: none'])?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?= Html::submitButton('Alterar', ['class' => 'btn-perfil']) ?>
                                        </div>
                                        <?php ActiveForm::end() ?>
                                    </div>
                                </div>
                            </div>


                        <?php }
                         if(sizeof($comentarios) > 3) {?>
                        <div class="showMoreComments">
                            <a><?=Html::encode('Mostar mais')?></a>
                        </div>
                    <?php }

                    } else { ?>
                        <p><?= Html::encode('Este livro ainda não tem nenhum comentário. Seja o primeiro a comentar!') ?></p>
                    <?php }?>
                </div>
            </div>

            <div class="col-xs-12 col-md-7 col-lg-6" id="bookDetails" style="margin-top: 3%">
                <h4>DETALHES DO LIVRO</h4>
                <div style="margin-top: 7%">
                    <h4><?= Html::encode($livro->titulo)?></h4>
                    <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                </div>
                <div class="row" style="margin-top: 4%">
                    <div class="col-xs-12 col-lg-4">
                        <p><?= Html::img(Yii::$app->request->baseUrl . '/../../backend/web/imgs/capas/' . $livro->capa, ['style' => 'width: 165px; height: 230px;'])?></p>
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
