<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\Models\Autor */

$this->title = 'Create Autor';
$this->params['breadcrumbs'][] = ['label' => 'Autors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
