<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Utilizador */

$this->title = 'Inserir Leitor';
$this->params['breadcrumbs'][] = ['label' => 'Leitores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizador-create">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <?php $form = ActiveForm::begin(['action' => ['utilizador/create'], 'id' => 'formInserirBibliotecario']) ?>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <?= $form->field($model, 'primeiro_nome')->textInput(['placeholder' => 'introduza o nome'])->label('Nome') ?>
            <?= $form->field($model, 'ultimo_nome')->textInput(['placeholder' => 'introduza o apelido'])->label('Apelido') ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'introduza o endereço de email']) ?>
            <?= $form->field($model, 'dta_nascimento')->label('Data de Nascimento')->input('date') ?>
            <?= $form->field($model, 'nif')->label('NIF')->textInput(['placeholder' => 'introduza o NIF']) ?>
            <?= $form->field($model, 'num_telemovel')->label('Nº de telefone')->textInput(['placeholder' => 'introduza o nº de telemóvel']) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'introduza a palavra-passe'])->label('Palavra-Passe') ?>
            <?= $form->field($model, 'confirmarPassword')->passwordInput(['placeholder' => 'confirmar palavra-passe'])->label('Confirmar Palavra-Passe') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('<i class="fas fa-plus"></i> Inserir', ['class' => 'btnAcao', 'id' => 'formInserirBibliotecario']) ?>
            </div>
        </div>
        <div class="col-sm-4"></div>
        <?php ActiveForm::end() ?>
    </div>

</div>
