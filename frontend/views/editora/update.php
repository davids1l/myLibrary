<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Editora */

$this->title = 'Update Editora: ' . $model->id_editora;
$this->params['breadcrumbs'][] = ['label' => 'Editoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_editora, 'url' => ['view', 'id' => $model->id_editora]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="editora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
