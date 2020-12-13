<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Biblioteca */

$this->title = 'Adicionar Biblioteca';
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row rowStyling">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-2"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cod_postal')->textInput(['maxlength' => true])->label('Código Postal') ?>
            <br/>
            <div class="form-group center">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <div class="col-md-2"></div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
