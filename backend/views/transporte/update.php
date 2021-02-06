<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transporte */

$this->title = 'Update Transporte: ' . $model->id_transporte;
$this->params['breadcrumbs'][] = ['label' => 'Transportes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_transporte, 'url' => ['view', 'id' => $model->id_transporte]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transporte-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
