
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
?>
<div class="catalogo-livros">
    <div class="container">
        <h1><?= Html::encode($this->title)?></h1>
        <div>
            <span>Categoria: </span>
            <?= Html::dropDownList('Dropdown Teste',null, ['Poesia', 'Comedia',] ) ?>
        </div>

        <hr>

        <?php if($livros != null) { ?>
            <?php foreach ($livros as $livro) { ?>
                <div class="col-xs-12 col-md-2 catalogo-grid">
                    <div class="capa">
                        <a href="<?= Url::to(['livros/detalhes', 'id' => $livro->id_livro]) ?>">
                            <?= Html::img($livro->capa, ['id'=> 'imgCapa'])?>
                        </a>
                    </div>
                    <div class="book-info">
                        <h4><?= Html::encode($livro->titulo)?></h4>
                        <h5><?= Html::encode($livro->genero)?></h5>
                        <h6>Idioma: <?= Html::encode($livro->idioma)?></h6>
                        <h6>Formato: <?= Html::encode($livro->formato)?></h6>
                    </div>
                    <?= Html::a('VER', ['livros/detalhes', 'id' => $livro->id_livro])?>
                </div>
            <?php }
        }?>
    </div>

</div>

