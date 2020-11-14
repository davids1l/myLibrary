<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Update Requisicao: ' . $model->id_requisicao;
$this->params['breadcrumbs'][] = ['label' => 'Requisicaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_requisicao, 'url' => ['view', 'id' => $model->id_requisicao]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="requisicao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
