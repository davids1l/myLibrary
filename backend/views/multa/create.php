<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Multa */

$this->title = 'Create Multa';
$this->params['breadcrumbs'][] = ['label' => 'Multas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
