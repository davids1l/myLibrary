<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Biblioteca */

$this->title = 'Editar Biblioteca: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="biblioteca-update">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">

        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label('Nome da Biblioteca') ?>
            <?= $form->field($model, 'cod_postal')->textInput()->label('Código Postal') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btnAcao']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4"></div>

    </div>

</div>
