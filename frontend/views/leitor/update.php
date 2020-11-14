<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leitor */

$this->title = 'Update Leitor: ' . $model->id_leitor;
$this->params['breadcrumbs'][] = ['label' => 'Leitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_leitor, 'url' => ['view', 'id' => $model->id_leitor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leitor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
