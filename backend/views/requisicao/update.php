<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Atualizar Requisição: ' . $model->id_requisicao;
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_requisicao, 'url' => ['view', 'id' => $model->id_requisicao]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="requisicao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rowStyling rowAddBook">
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <?= $form->field($model, 'dta_levantamento')->label('Data de levantamento')->input('datetime-local') ?>
                <?= $form->field($model, 'dta_entrega')->label('Data de entrega')->input('datetime-local') ?>
                <?= $form->field($model, 'estado')->textInput() ?>
                <?= $form->field($model, 'id_utilizador')->dropDownList($users)->label('Nome de utilizador') ?>
                <?= $form->field($model, 'id_bib_levantamento')->dropDownList($bibliotecas)->label('Biblioteca') ?>

            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
