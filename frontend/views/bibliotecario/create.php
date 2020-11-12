<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bibliotecario */

$this->title = 'Create Bibliotecario';
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bibliotecario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
