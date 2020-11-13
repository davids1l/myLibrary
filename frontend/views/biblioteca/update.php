<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Biblioteca */

$this->title = 'Update Biblioteca: ' . $model->id_biblioteca;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_biblioteca, 'url' => ['view', 'id' => $model->id_biblioteca]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="biblioteca-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
