<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BibliotecarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leitores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>


    <div>
        <?= Html::button('Inserir Leitor', ['data-toggle' => 'modal', 'data-target' => '#criarLeitorModal']) ?>
    </div>
    <br>


    <?= GridView::widget([
        'summary' => 'Total de Leitores: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'numero',
                'label' => 'Nº de Leitor',
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
            [
                'attribute' => 'bloqueado',
                'value' => function ($model) {
                    if ($model->bloqueado != 1) {
                        return '';
                    } else {
                        return 'Bloqueado';
                    }
                }
            ],
            [
                'attribute' => 'dta_bloqueado',
                'label' => 'Data do bloqueio',
                'value' => function ($model) {
                    if ($model->dta_bloqueado == null) {
                        return '';
                    } else {
                        return Carbon::parse($model->dta_bloqueado)->format('d-m-Y H:i:s');
                    }
                }
            ],

            [
                'attribute' => 'num_telemovel',
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
                'value' => function ($model) {
                    return Carbon::parse($model->dta_nascimento)->format('d-m-Y');
                }

            ],
            //'dta_registo',
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
                'template' => /*{view}*/ '{bloquear} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'data' => [
                                'confirm' => 'Tem a certeza que quer eliminar o leitor com o nº ' . $model->numero . '?',
                                'method' => 'post',
                            ]
                        ]);
                    },

                    'bloquear' => function ($url, $model) {
                        if ($model->bloqueado != 1) {
                            return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $url, [
                                'data' => [
                                    'confirm' => 'Tem a certeza que quer bloquear o leitor com o nº ' . $model->numero . '?'
                                ]
                            ]);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-ok-circle"></span>', $url, [
                                'data' => [
                                    'confirm' => 'Tem a certeza que quer desbloquear o leitor com o nº ' . $model->numero . '?'
                                ]
                            ]);
                        }
                    }
                ]

            ],
        ],
    ]); ?>
</div>


<!-- Modal para criar leitor -->
<div class="modal fade" id="criarLeitorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Criar Leitor</h2>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <?php $form = ActiveForm::begin([
                        'action' => ['utilizador/create']]) ?>
                    <div class="row">
                        <?= $form->field($model, 'primeiro_nome')->textInput(['autofocus' => true])->label('Primeiro nome') ?>
                        <?= $form->field($model, 'ultimo_nome')->label('Apelido') ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'dta_nascimento')->label('Data de Nascimento')->input('date') ?>
                        <?= $form->field($model, 'nif')->label('NIF') ?>
                        <?= $form->field($model, 'num_telemovel')->label('Nº de telefone') ?>
                        <?= $form->field($model, 'password')->passwordInput()->label('Palavra-Passe') ?>
                        <?= $form->field($model, 'confirmarPassword')->passwordInput()->label('Confirmar Palavra-Passe') ?>
                    </div>
                    <div class="modal-footer">
                        <?= Html::submitButton('Inserir Leitor', ['class' => 'btn-perfil']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
                <div class="col-sm-2"></div>
            </div>

        </div>
    </div>
</div>
