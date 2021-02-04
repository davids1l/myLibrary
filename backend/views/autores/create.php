<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Autor */

$this->title = 'Adicionar Autor';
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autor-create">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?= $form->field($model, 'nome_autor')->textInput(['maxlength' => true, 'placeholder' => 'introduza o nome do autor'])->label('Nome do Autor') ?>
            <?= $form->field($model, 'id_pais')->dropDownList($paises)->label('País') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('<i class="fas fa-plus"></i> Adicionar', ['class' => 'btnAcao']) ?>
            </div>

        </div>
        <div class="col-md-4"></div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
