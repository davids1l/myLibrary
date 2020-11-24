<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Livro */

$this->title = 'Update Livro: ' . $model->id_livro;
$this->params['breadcrumbs'][] = ['label' => 'Livros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_livro, 'url' => ['view', 'id' => $model->id_livro]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="livro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
