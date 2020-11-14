
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $livros app\controllers\LivrosController */

use yii\helpers\Html;
use yii\widgets\LinkPager;

\frontend\assets\AppAsset::register($this);

$this->title = "Catálogo de Livros";

//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogo-livros">
    <div class="container">
        <h1><?= Html::encode($this->title)?></h1>
        <hr>

        <?php if($livros != null) { ?>
            <?php foreach ($livros as $livro) { ?>
                <div class="col-md-2 catalogo-grid">
                    <div class="capa">
                        <a href="#">
                            <img src="<?= $livro->capa ?>">
                        </a>
                    </div>
                    <div class="book-info">
                        <h4><?= Html::encode("$livro->titulo")?></h4>
                        <h5><?= $livro->genero ?></h5>
                        <h6>Idioma: <?= $livro->idioma ?></h6>
                        <h6>Formato: <?=$livro->formato ?></h6>
                    </div>
                    <?= Html::a('VER', ['site/detalhes', 'id' => $livro->id_livro])?>
                </div>
                <?php }
        }?>

    </div>

</div>

