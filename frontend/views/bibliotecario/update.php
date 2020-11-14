<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bibliotecario */

$this->title = 'Update Bibliotecario: ' . $model->id_bibliotecario;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_bibliotecario, 'url' => ['view', 'id' => $model->id_bibliotecario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bibliotecario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
