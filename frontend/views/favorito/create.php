<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Favorito */

$this->title = 'Create Favorito';
$this->params['breadcrumbs'][] = ['label' => 'Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favorito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
