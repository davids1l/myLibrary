<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BibliotecaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catálogo - ' . $model->nome;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-index">
    <h1>Catálogo - <?= Html::encode($model->nome)?></h1>
    <?= Html::a('Voltar atrás', ['bibliotecas/index'])?>
    <hr/>

    <?php if($livros != null) { ?>
        <?php foreach ($livros as $livro) { ?>
            <div class="col-xs-12 col-md-2 catalogo-grid gridLivros">
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

                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> Detalhes', ['livros/view', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-primary book-buttons'
                ])?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Atualizar', ['livros/update', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-success book-buttons'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Eliminar', ['delete', 'id' => $livro->id_livro], [
                    'class' => 'btn btn-danger book-buttons',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>

            </div>
        <?php }
    } else { ?>
        <br/>
        <p>Parece que não foram encontrados livros.</p>
    <?php } ?>


</div>
