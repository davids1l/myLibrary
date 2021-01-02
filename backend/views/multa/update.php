<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Multa */

$this->title = 'Update Multa: ' . $model->id_multa;
$this->params['breadcrumbs'][] = ['label' => 'Multas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_multa, 'url' => ['view', 'id' => $model->id_multa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="multa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
