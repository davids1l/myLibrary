<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Autor */

$this->title = 'Editar Autor: ' . $model->nome_autor;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome_autor];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="autor-update">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?= $form->field($model, 'nome_autor')->textInput(['maxlength' => true])->label('Nome do Autor') ?>
            <?= $form->field($model, 'id_pais')->dropDownList($paises)->label('País') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btnAcao']) ?>
            </div>

        </div>
        <div class="col-md-4"></div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
