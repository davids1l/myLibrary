<?php

/* @var $this yii\web\View */

use Carbon\Carbon;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Painel';
$utilizadorSession = Yii::$app->session->get('dadosUser');
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requisições por tratar</h3>
                    </div>
                    <div class="panel-body">
                        <?= GridView::widget([
                            'summary' => 'Total de Requisições: {totalCount}',
                            'dataProvider' => $dataProviderTratar,
                            'filterModel' => $searchModel,
                            'emptyText' => 'Não existem requisições pendentes.',
                            'columns' => [
                                [
                                    'attribute' => 'id_requisicao',
                                    'label' => 'Nº da Requisição',
                                ],
                                [
                                    'attribute' => 'id_utilizador',
                                    'value' => 'utilizador.numero',
                                    'label' => 'Nº de leitor'
                                ],
                                [
                                    'attribute' => '',
                                    'value' => function ($url, $model, $key) {


                                        $total = \app\models\RequisicaoLivro::find()->where(['id_requisicao' => $model])->all();

                                        $sub =  \app\models\Livro::find()->where(['id_biblioteca' => $url->id_bib_levantamento]);
                                        $totalProntos = \app\models\RequisicaoLivro::find()->where(['id_requisicao' => $model])->innerJoin(['sub' => $sub], 'sub.id_livro = requisicao_livro.id_livro')->all();

                                       //var_dump($totalProntos);die();
                                        return Html::encode(count($totalProntos).'/'.count($total));
                                    },
                                    'label' => 'Livros'
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{preparar}',
                                    'buttons' => [
                                        'preparar' => function ($url, $model, $key) {
                                            $total = \app\models\RequisicaoLivro::find()->where(['id_requisicao' => $model])->all();
                                            $sub =  \app\models\RequisicaoLivro::find()->where(['id_requisicao' => $model]);
                                            $totalProntos = \app\models\Livro::find()->where(['id_biblioteca' => $model->id_bib_levantamento])->innerJoin(['sub' => $sub])->all();

                                            if ($model->estado === "A aguardar tratamento" && (count($totalProntos) == count($total))) {
                                                return Html::a('Tratar requisição', ['site/livro', 'id' => $model->id_requisicao], ['class' => 'btn btn-success',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ]
                                                ]);
                                            } else {
                                                return Html::label('A aguardar transporte de livros');
                                            }
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['site/delete', 'id' => $model->id_requisicao], [
                                                'data' => [
                                                    'confirm' => 'Pretende eliminar esta requisição?',
                                                    'method' => 'post',
                                                ]
                                            ]);
                                        }
                                    ]
                                ]
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requisições prontas a entregar</h3>
                    </div>
                    <div class="panel-body">
                        <?= GridView::widget([
                            'summary' => 'Total de Requisições: {totalCount}',
                            'dataProvider' => $dataProviderEntregar,
                            'filterModel' => $searchModel,
                            'emptyText' => 'Não existem requisições pendentes.',
                            'columns' => [
                                [
                                    'attribute' => 'id_requisicao',
                                    'label' => 'Nº da Requisição',
                                ],
                                [
                                    'attribute' => 'id_utilizador',
                                    'value' => 'utilizador.numero',
                                    'label' => 'Nº de leitor'
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{entregar}',
                                    'buttons' => [
                                        'entregar' => function ($url, $model, $key) {
                                            if ($model->estado === "Pronta a levantar") {
                                                return Html::a('Finalizar requisição', ['site/levantar', 'id' => $model->id_requisicao], ['class' => 'btn btn-success',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ]
                                                ]);
                                            } else {
                                                return Html::label('Terminada');
                                            }
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['site/delete', 'id' => $model->id_requisicao], [
                                                'data' => [
                                                    'confirm' => 'Pretende eliminar esta requisição?',
                                                    'method' => 'post',
                                                ]
                                            ]);
                                        }
                                    ]
                                ]
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Criar requisição</h3>
                    </div>
                    <div class="panel-body">
                        <div class="rowAddBook">
                            <div class="row" style="display: flex; justify-content: center; align-items: center;">

                                <div class="col-md-7">
                                    <?php $form = ActiveForm::begin([
                                        'id' => 'pesquisa-form',
                                        'options' => ['class' => 'form-horizontal'],
                                        'action' => ['site/add-user']
                                    ]) ?>

                                    <?= $form->field($searchModelCriarReq, 'numero')->label('Indique o número de leitor: '); ?>
                                </div>
                                <div class="col-md-5" style="display: flex; justify-content: left; align-items: center;">
                                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Pesquisar', ['className' => 'pesquisa', 'class' => 'btn btn-primary']); ?>
                                    <?php ActiveForm::end() ?>
                                    <br/>
                                </div>
                            </div>
                            <div class="row">
                                <?php $form = ActiveForm::begin([
                                    'action' => ['requisicao/create']
                                ]); ?>
                                <div class="col-md-8">
                                    <div class="row">
                                        <?php if($utilizadorSession != null) {
                                            foreach ($utilizadorSession as $utilizador) { ?>
                                                <br/>
                                                <h4>Dados do leitor: </h4>
                                                <br/>
                                                <p>Nome: <?= $utilizador->primeiro_nome . " " . $utilizador->ultimo_nome ?></p>
                                                <p>Numero: <?= $utilizador->numero ?></p>
                                            <?php } ?>
                                            <br>
                                            <?= Html::submitButton('Seguinte', ['class' => 'btn btn-primary']) ?>
                                        <?php } else { ?>
                                            <br/>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Requisições ativas</h3>
                    </div>
                    <div class="panel-body">
                        <?= GridView::widget([
                            'summary' => 'Total de Requisições: {totalCount}',
                            'dataProvider' => $dataProviderTerminar,
                            'filterModel' => $searchModel,
                            'emptyText' => 'Não existem requisições pendentes.',
                            'columns' => [
                                [
                                    'attribute' => 'id_requisicao',
                                    'label' => 'Nº da Requisição',
                                ],
                                [
                                    'attribute' => 'id_utilizador',
                                    'value' => 'utilizador.numero',
                                    'label' => 'Nº de leitor'
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{terminar}',
                                    'buttons' => [
                                        'terminar' => function ($url, $model, $key) {
                                            if ($model->estado === "Em requisição") {
                                                return Html::a('Terminar requisição', ['site/terminar', 'id' => $model->id_requisicao], ['class' => 'btn btn-danger',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ]
                                                ]);
                                            } else {
                                                return Html::label('Terminada');
                                            }
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['site/delete', 'id' => $model->id_requisicao], [
                                                'data' => [
                                                    'confirm' => 'Pretende eliminar esta requisição?',
                                                    'method' => 'post',
                                                ]
                                            ]);
                                        }
                                    ]
                                ]
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>



            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Transportes por tratar</h3>
                    </div>
                    <div class="panel-body">
                        <?= GridView::widget([
                            'summary' => '<li class="list-group-item">Total de transportes a tratar <span class="badge" style="background-color: #b92c28">{totalCount}</span></li>',
                            'dataProvider' => $dataProviderTransportesPorTratar,
                            'filterModel' => $searchModelTransporte,
                            'emptyText' => 'Não existem transportes pendentes.',
                            'columns' => [
                                [
                                    'attribute' => 'id_transporte',
                                    'label' => 'Nº do transporte',
                                ],
                                /*[
                                    'attribute' => 'id_requisicao',
                                    'label' => 'Nº da Requisição',
                                ],*/
                                [
                                    'attribute' => 'id_bib_recetora',
                                    'value' => function ($model) {
                                        $bib = \app\models\Biblioteca::find()->select(['nome', 'cod_postal'])->where(['id_biblioteca' => $model->id_bib_recetora])->one();
                                        return ($bib['nome'].' - '.$bib['cod_postal']);
                                    },
                                    'label' => 'Bib. destino'
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{preparar}',
                                    'buttons' => [
                                        'preparar' => function ($url, $model, $key) {
                                            if ($model->estado === "A aguardar tratamento") {
                                                return Html::a('Tratar transporte', ['transporte/tratar', 'id' => $model->id_transporte], ['class' => 'btn btn-success',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ]
                                                ]);
                                            }
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['site/delete', 'id' => $model->id_requisicao], [
                                                'data' => [
                                                    'confirm' => 'Pretende cancelar este transporte?',
                                                    'method' => 'post',
                                                ]
                                            ]);
                                        }
                                    ]
                                ]
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Transportes a receber</h3>
                    </div>
                    <div class="panel-body">
                        <?= GridView::widget([
                            'summary' => '<li class="list-group-item">Total de transportes a receber <span class="badge" style="background-color: #b92c28">{totalCount}</span></li>',
                            'dataProvider' => $dataProviderTransportesAReceber,
                            'filterModel' => $searchModelTransporte,
                            'emptyText' => 'Não existem transportes pendentes.',
                            'columns' => [
                                [
                                    'attribute' => 'id_transporte',
                                    'label' => 'Nº do transporte',
                                ],
                                /*[
                                    'attribute' => 'id_requisicao',
                                    'label' => 'Nº da Requisição',
                                ],*/
                                [
                                    'attribute' => 'id_bib_despacho',
                                    'value' => function ($model) {
                                        $bib = \app\models\Biblioteca::find()->select(['nome', 'cod_postal'])->where(['id_biblioteca' => $model->id_bib_recetora])->one();
                                        return ($bib['nome'].' - '.$bib['cod_postal']);
                                    },
                                    'label' => 'Bib. origem'
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{preparar}',
                                    'buttons' => [
                                        'preparar' => function ($url, $model, $key) {
                                            if ($model->estado === "Em transporte") {
                                                return Html::a('Validar transporte', ['transporte/receber', 'id' => $model->id_transporte], ['class' => 'btn btn-success',
                                                    'data' => [
                                                        'method' => 'post',
                                                    ]
                                                ]);
                                            }
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['site/delete', 'id' => $model->id_requisicao], [
                                                'data' => [
                                                    'confirm' => 'Pretende cancelar este transporte?',
                                                    'method' => 'post',
                                                ]
                                            ]);
                                        }
                                    ]
                                ]
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
