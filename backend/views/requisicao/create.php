<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Adicionar Requisição';
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rowStyling rowAddBook">
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <?= $form->field($model, 'dta_levantamento')->label('Data de levantamento')->input('date') ?>
                <?= $form->field($model, 'dta_entrega')->label('Data de entrega')->input('date') ?>
                <?= $form->field($model, 'estado')->textInput() ?>
                <?= $form->field($model, 'id_utilizador')->textInput() ?>
                <?= $form->field($model, 'id_bib_levantamento')->textInput() ?>
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
