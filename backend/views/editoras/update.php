<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Editora */

$this->title = 'Atualizar Editora: ' . $model->id_editora;
$this->params['breadcrumbs'][] = ['label' => 'Editoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_editora, 'url' => ['view', 'id' => $model->id_editora]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="editora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row rowStyling">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?= $form->field($model, 'designacao')->textInput(['maxlength' => true])->label('Designação') ?>
            <?= $form->field($model, 'id_pais')->dropDownList($paises)->label('País') ?>

            <div class="form-group center">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
        <div class="col-md-4"></div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
