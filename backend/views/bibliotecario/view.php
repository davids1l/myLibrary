<?php

use app\models\Biblioteca;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Utilizador */

$this->title = $model->primeiro_nome . " " . $model->ultimo_nome;
$this->params['breadcrumbs'][] = ['label' => 'Bibliotecários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="utilizador-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alterar Biblioteca', null, [
            'data-toggle' => 'modal',
            'data-target' => '#updateBibliotecarioModal',
            'class' => 'btn btn-primary'])
        ?>

        <?php
        if ($model->id_biblioteca != null) {
            echo Html::a('Desassociar da Biblioteca', ['bibliotecario/remover-biblioteca', 'id' => $model->id_utilizador], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que quer desassociar o bibliotecário com o nº ' . $model->numero . ' da biblioteca ' . $model->biblioteca->nome . '?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>


        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_utilizador], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer eliminar o bibliotecário com o nº ' . $model->numero . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'foto_perfil',
                'label' => '',
                'format' => 'html',
                'filter' => false,
                'value' => function ($model) {
                    return Html::img(Yii::$app->request->baseUrl . '/../../frontend/web/imgs/perfil/' . $model['foto_perfil'], ['width' => '100px']);
                }
            ],

            [
                'attribute' => 'numero',
                'label' => 'Nº de Bibliotecário',
            ],

            [
                'value' => function ($model) {
                    return $model->primeiro_nome . " " . $model->ultimo_nome;
                },
                'label' => 'Nome',
            ],

            [
                'attribute' => 'user.email',
                'label' => 'Email',
            ],

            [
                'attribute' => 'dta_nascimento',
                'label' => 'Data de Nascimento',
            ],

            [
                'attribute' => 'nif',
                'label' => 'NIF',
            ],

            [
                'attribute' => 'num_telemovel',
                'label' => 'Nº de Telemóvel',
            ],

            [
                'attribute' => 'biblioteca.nome',
                'value' => function ($model){
                    if($model->id_biblioteca == null){
                        return '';
                    }else{
                        $nomeBibli = Biblioteca::find()->where(['id_biblioteca' => $model->id_biblioteca])->one();
                        return $nomeBibli->nome;
                    }
                },
                'label' => 'Biblioteca associada'
            ],

        ],
    ]) ?>


    <!-- Modal para editar a biblioteca onde o bibliotecario está associado-->
    <div class="modal fade" id="updateBibliotecarioModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel">Alterar Biblioteca</h2>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <?php $form = ActiveForm::begin([
                            'action' => ['bibliotecario/update-biblioteca', 'id' => $model->id_utilizador]]) ?>
                        <div class="row">
                            <?= $form->field($model, 'id_biblioteca')->label('Biblioteca')->dropDownList($bibliotecas) ?>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Guardar', ['class' => 'btn-perfil']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>

</div>
