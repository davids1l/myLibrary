<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Create Requisicao';
$this->params['breadcrumbs'][] = ['label' => 'Requisicaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
