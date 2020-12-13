<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\Models\Autor */

$this->title = 'Update Autor: ' . $model->id_autor;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_autor, 'url' => ['view', 'id' => $model->id_autor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="autor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
