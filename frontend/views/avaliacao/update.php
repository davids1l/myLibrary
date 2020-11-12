<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Avaliacao */

$this->title = 'Update Avaliacao: ' . $model->id_avaliacao;
$this->params['breadcrumbs'][] = ['label' => 'Avaliacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_avaliacao, 'url' => ['view', 'id' => $model->id_avaliacao]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="avaliacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
