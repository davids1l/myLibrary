<?php

use app\models\Biblioteca;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BibliotecarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bibliotecários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizador-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div>
        <a style="color: black">
            <?= Html::button('Inserir Bibliotecário', ['data-toggle' => 'modal', 'data-target' => '#criarBibliotecarioModal', 'id' => 'inserirBibliotecario']) ?>
        </a>
    </div>
    <br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'summary' => 'Total de Bibliotecários: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'numero',
                'label' => 'Nº de bibliotecário',
            ],
            //'id_utilizador',
            [
                'attribute' => 'primeiro_nome',
                'label' => 'Nome',
            ],
            [
                'attribute' => 'ultimo_nome',
                'label' => 'Apelido',
            ],
            //'bloqueado',
            //'dta_bloqueado',

            [
                'attribute' => 'num_telemovel',
                'value' => 'num_telemovel',
                'label' => 'Nº de telemóvel',
            ],
            [
                'attribute' => 'id_utilizador',
                'value' => 'user.email',
                'label' => 'Email',
            ],
            [
                'attribute' => 'nif',
                'label' => 'NIF',
            ],
            [
                'attribute' => 'dta_nascimento',
                'label' => 'Data de Nascimento',

            ],
            //'dta_registo',
            [
                'attribute' => 'id_biblioteca',
                'value' => 'biblioteca.nome',
                'label' => 'Biblioteca',
            ],
            [
                'attribute' => 'foto_perfil',
                'format' => 'html',
                'filter' => false,
                'value' => function ($dados) {
                     return Html::img(Yii::$app->request->baseUrl . '/../../frontend/web/imgs/perfil/' . $dados['foto_perfil'], ['width' => '60px', 'height' => '60px']);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'template' => '{view} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'data' => [
                                'confirm' => 'Tem a certeza que quer eliminar o bibliotecário com o nº ' . $model->numero . '?',
                                'method' => 'post',
                            ]
                        ]);
                    },
                ]

            ],
        ],
    ]); ?>


    <!-- Modal para criar um bibliotecario -->
    <div class="modal fade" id="criarBibliotecarioModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel">Inserir Bibliotecário</h2>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <?php $form = ActiveForm::begin(['action' => ['bibliotecario/create']]) ?>
                        <div class="row">
                            <?= $form->field($model, 'primeiro_nome')->textInput(['autofocus' => true])->label('Primeiro nome') ?>
                            <?= $form->field($model, 'ultimo_nome')->label('Apelido') ?>
                            <?= $form->field($model, 'email') ?>
                            <?= $form->field($model, 'dta_nascimento')->label('Data de Nascimento')->input('date') ?>
                            <?= $form->field($model, 'nif')->label('NIF') ?>
                            <?= $form->field($model, 'num_telemovel')->label('Nº de telefone') ?>
                            <?= $form->field($model, 'id_biblioteca')->label('Biblioteca')->dropDownList($bibliotecas)?>
                            <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>
                            <?= $form->field($model, 'confirmarPassword')->passwordInput()->label('Confirmar Palavra-Passe') ?>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Inserir Bibliotecário', ['class' => 'btn-perfil', 'id' => 'inserirBibliotecario']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>


</div>
