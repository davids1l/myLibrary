<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Livro */

$this->title = 'Update Livro: ' . $model->id_livro;
$this->params['breadcrumbs'][] = ['label' => 'Livros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_livro, 'url' => ['view', 'id' => $model->id_livro]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="livro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4">
            <?= $form->field($model, 'capa')->textInput(['id' => 'files','maxlength' => true]) ?>
            <?= Html::img('',['id' => 'image', 'style' => 'width: 70%']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ano')->textInput() ?>
            <?= $form->field($model, 'paginas')->textInput() ?>
            <?= $form->field($model, 'genero')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'idioma')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'formato')->textInput(['maxlength' => true]) ?>

            <?php //$form->field($model, 'id_editora')->dropDownList($editoras) ?>
            <?php //$form->field($model, 'id_biblioteca')->dropDownList($bibliotecas) ?>
            <?php //$form->field($model, 'id_autor')->dropDownList($autores) ?>

            <div class="form-group center">
                <?= Html::submitButton('Save', ['class' => '']) ?>
            </div>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sinopse')->textarea(['rows' => 20]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
