<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Biblioteca */

$this->title = 'Update Biblioteca: ' . $model->id_biblioteca;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_biblioteca, 'url' => ['view', 'id' => $model->id_biblioteca]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="biblioteca-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">

        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'id_biblioteca')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cod_postal')->textInput() ?>

            <div class="form-group center">
                <?= Html::submitButton('Save', ['class' => '']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4"></div>

    </div>

</div>
