<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Biblioteca */

$this->title = 'Inserir Biblioteca';
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-create">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'introduza o nome da biblioteca'])->label('Nome da Biblioteca') ?>
            <?= $form->field($model, 'cod_postal')->textInput(['maxlength' => true, 'placeholder' => 'introduza o código postal (ex: 1234 567)', 'pattern' => '^\\d{4}-\\d{3}$'])->label('Código Postal') ?>
            <div class="form-group text-center">
                <?= Html::submitButton('<i class="fas fa-plus"></i> Inserir', ['class' => 'btnAcao']) ?>
            </div>
        </div>
        <div class="col-md-4"></div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
