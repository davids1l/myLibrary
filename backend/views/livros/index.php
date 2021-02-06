<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LivroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Livros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="livro-index">
    <h1 class="topicos"><?= Html::encode($this->title)?></h1>
    <hr>

    <div class="searchBar">
        <div class="pesquisaSimples" style="display: flex;" >
            <div class="col-xs-11 col-md-11 termosPesquisa">
                <?php $form = ActiveForm::begin(['id'=>'pesquisa-form', 'options' => ['class' => 'form-horizontal'], 'action'=>['livros/procurar']]); ?>
                <?= $form->field($searchModel, 'titulo')->textInput(['placeholder'=>'Pesquisar'])->label('')?>
            </div>
            <div class="col-xs-1 col-md-1 btnProcurar" style="margin-top: 20px">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btnAcao', 'style' => 'width: 100%']) ?>
            </div>
        </div>

        <div class="pesquisaDetalhada">
            <a href="#" id="pesquisaAvancada" class="pesquisaAvancada" data-content="toggle-text">Filtros de pesquisa<i id="mostrarFiltrosPesquisa" class="fa fa-caret-down"></i></a>
            <div class="filtros-pesquisa"> <!-- display: none; -->
                <?= Html::beginForm(['favorito/index'], 'post')?>
                <div style="display: flex">
                    <div class="col-md-6">
                        <?= $form->field($searchModel, 'formato')->dropDownList(['Físico', 'Ebook'], ['prompt'=>'Selecione o formato...'])?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($searchModel, 'genero')->dropDownList($generos, ['prompt'=>'Selecione o gênero...'])?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


    <div style="margin-top: 15px">
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Inserir Livro', ['livros/create'], [
            'class' => 'btnAcao',
            'id' => 'adicionarLivro'
        ]); ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar todos', ['livros/index'], [
            'class' => 'btnAcao'
        ]); ?>
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span> Mostrar requisitados', ['livros/requisitado'], [
            'class' => 'btnAcao'
        ]); ?>
    </div>

    <br/>


    <?php if($livros != null) { ?>
        <?php foreach ($livros as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid gridLivros" style="height: auto; width: 210px; margin: 10px">
                <div class="capa text-center" style="margin-top: 10px">
                    <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                        <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livro->capa, ['id'=> 'imgCapa', 'style' => 'width: 140px; height: 220px;'])?>
                    </a>
                </div>
                <div class="book-info text-center" style="height: 150px; display: block">
                    <h4 id="titulo" style="letter-spacing: 1px"><?= Html::encode($livro->titulo)?></h4>
                    <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                    <h6><?= Html::encode($livro->genero)?></h6>
                    <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                    <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                </div>

                <div class="text-center">
                    <?= Html::a('<span class="fas fa-eye"></span>', ['livros/view', 'id' => $livro->id_livro], [
                        'class' => 'btn book-buttons', 'style' => 'color: black'
                    ])?>
                    <?= Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $livro->id_livro], [
                        'class' => 'btn  book-buttons',
                        'style' => 'color: black',
                        'data' => [
                            'confirm' => 'Tem a certeza que pretende eliminar este livro?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        <?php }
    } else if($livrosAutor != null){ ?>
        <?php foreach ($livrosAutor as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid gridLivros" style="height: auto; width: 210px; margin: 10px">
                <div class="capa text-center" style="margin-top: 10px">
                    <a href="<?= Url::to(['livros/view', 'id' => $livro->id_livro]) ?>">
                        <?= Html::img(Yii::$app->request->baseUrl . '/imgs/capas/' . $livro->capa, ['id'=> 'imgCapa', 'style' => 'width: 140px; height: 220px;'])?>
                    </a>
                </div>
                <div class="book-info text-center" style="height: 150px; display: block">
                    <h4 id="titulo" style="letter-spacing: 1px"><?= Html::encode($livro->titulo)?></h4>
                    <h5>de <?= Html::encode($livro->autor->nome_autor)?></h5>
                    <h6><?= Html::encode($livro->genero)?></h6>
                    <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                    <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                </div>

                <div class="text-center">
                    <?= Html::a('<span class="fas fa-eye"></span>', ['livros/view', 'id' => $livro->id_livro], [
                        'class' => 'btn book-buttons', 'style' => 'color: black'
                    ])?>
                    <?= Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $livro->id_livro], [
                        'class' => 'btn  book-buttons',
                        'style' => 'color: black',
                        'data' => [
                            'confirm' => 'Tem a certeza que pretende eliminar este livro?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        <?php }
            } else { ?>
        <br/>
        <p>Parece que não foram encontrados livros.</p>
    <?php } ?>

    <?php /* $this->render('_search', [
        'model' => $model,
    ]) */?>


</div>
