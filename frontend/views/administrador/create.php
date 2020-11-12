<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Administrador */

$this->title = 'Create Administrador';
$this->params['breadcrumbs'][] = ['label' => 'Administradors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
