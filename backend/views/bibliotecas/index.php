<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BibliotecaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bibliotecas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-index">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Inserir biblioteca', ['bibliotecas/create'], ['class' => 'btnAcao']); ?>
    <br/>

    <div class="row" style="margin-top: 20px">
        <?php if ($bibliotecas != null) { ?>
        <?php foreach ($bibliotecas as $biblioteca) { ?>
            <div class="col-xs-12 col-md-4 listaBiblioteca">
                <h4><?= Html::encode($biblioteca->nome) ?></h4>
                <h6>Código postal: <?= Html::encode($biblioteca->cod_postal) ?></h6>

                <div>
                    <?= Html::a('<span class="fas fa-book"></span> Catálogo', ['bibliotecas/catalogo', 'id' => $biblioteca->id_biblioteca], ['class' => 'btnAcao']) ?>
                    <?= Html::a('<span class="far fa-edit"></span>', ['bibliotecas/update', 'id' => $biblioteca->id_biblioteca], ['class' => 'btn book-buttons', 'style' => 'color: black; margin-top: 10px']) ?>
                    <?= Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $biblioteca->id_biblioteca], [
                        'class' => 'btn book-buttons',
                        'style' => 'color: black; margin-top: 10px',
                        'data' => [
                            'confirm' => 'Tem a certeza que pretende eliminar esta biblioteca?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

            </div>
        <?php } ?>
    </div>
    <?php } else { ?>
<br/>
    <p>Parece que não foram encontradas bibliotecas no sistema.</p>
<?php } ?>
</div>
