<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leitor */

$this->title = 'Create Leitor';
$this->params['breadcrumbs'][] = ['label' => 'Leitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leitor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
