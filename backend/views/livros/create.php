<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Livro */

$this->title = 'Inserir Livro';
$this->params['breadcrumbs'][] = ['label' => 'Livros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="livro-create">

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row" style="box-shadow: 0 0 5px lightgrey;padding: 10px">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3">

                <?= $form->field($modelUpload, 'imageFile')->fileInput(['id' => 'files'])->label('Escolha a imagem:') ?>
                <?= Html::img('#',['id' => 'imagemCapa', 'style' => 'width: 70%']) ?>

                <script type="text/JavaScript">
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('imagemCapa').src = e.target.result;
                    }
                    function previewImage(input) {
                        if (input.files && input.files[0]) {
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    document.getElementById('files').addEventListener('change', function () {
                        previewImage(this);
                    })
                </script>

            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Título') ?>
                <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'ano')->textInput() ?>
                <?= $form->field($model, 'paginas')->textInput()->label('Páginas') ?>
                <?= $form->field($model, 'genero')->textInput(['maxlength' => true])->label('Gênero') ?>
                <?= $form->field($model, 'idioma')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'formato')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'id_editora')->dropDownList($editoras)->label('Editora') ?>

            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_biblioteca')->dropDownList($bibliotecas)->label('Biblioteca') ?>
                <?= $form->field($model, 'id_autor')->dropDownList($autores)->label('Autor') ?>
                <?= $form->field($model, 'sinopse')->textarea(['rows' => 20]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group text-center">
                    <?= Html::submitButton('<i class="fas fa-plus"></i> Inserir', ['class' => 'btnAcao', 'id' => 'livroCreateGuardar']) ?>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
