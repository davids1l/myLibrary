<?php

use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequisicaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $multas app\controllers\RequisicaoController*/

$this->title = 'Histórico de Requisicões';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>


    <?= GridView::widget([
        'summary' => 'Total de Requisições: {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id_requisicao',
                'label' => 'Nº da Requisição',
            ],
            [
                'label' => 'Nº de Livros',
                'value' => function ($model) {
                    return RequisicaoLivro::find()->where(['id_requisicao' => $model->id_requisicao])->count();
                }
            ],
            [
                'attribute' => 'dta_levantamento',
                'label' => 'Data de Levantamento',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_levantamento)->format('d-m-Y H:i:s');
                },
            ],
            [
                'attribute' => 'dta_entrega',
                'label' => 'Data de Entrega',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_entrega)->format('d-m-Y H:i:s');
                }
            ],
            'estado',
            [
                'attribute' => 'id_bib_levantamento',
                'value' => 'biblioteca.nome',
                'label' => 'Biblioteca de Levantamento'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'template' => '{view} {multa}',
                'buttons' => [
                    'view' => function ($url, $dataProvider, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['requisicao/showmodal', 'key'=> $key]); //glyphicon glyphicon-exclamation-sign
                    },
                    'multa' => function ($key, $model) {

                        //return Html::a('', null, ['class' => 'glyphicon glyphicon-exclamation-sign', 'style' => 'cursor: pointer',
                        //'data-toggle'=>'modal', 'data-target' => "#multasModal" ]);

                        //}
                        //if (isset($multas)) {
                            //foreach ($multas as $item) {
                                //if ($item->id_requisicao == $model->id_requisicao) {
                                    return Html::a('<span class="glyphicon glyphicon-exclamation-sign"></span>', ['requisicao/showmultamodal', 'key' => $key, 'id_requisicao' => $model->id_requisicao]);
                                //}
                            //}
                        //}
                    }
                ]
            ],
        ],
    ]); ?>


    <!-- Modal para mostrar a lista de livros -->
    <div class="modal fade" id="livrosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel">Requisição #<?= $key ?></h2>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <?php
                        $livros = RequisicaoLivro::find()->where(['id_requisicao' => $key])->all();
                        foreach ($livros as $livro) {
                            $detalhes = Livro::find()->where(['id_livro' => $livro->id_livro])->one();
                            echo DetailView::widget([
                                'model' => $detalhes,
                                'attributes' => [
                                    [
                                        'label' => 'Título',
                                        'value' => function ($detalhes) {
                                            return $detalhes->titulo;
                                        }
                                    ],
                                    [
                                        'label' => 'Capa',
                                        'format' => 'html',
                                        'value' => function ($detalhes) {
                                            return Html::img($detalhes->capa, ['width' => '100px']);
                                        }
                                    ],
                                ]
                            ]);
                        }
                        ?>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para mostrar multa -->
    <div class="modal fade" id="multasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="exampleModalLabel"><?= Html::encode('Multa - Requisição') ?></h2>
                </div>
                <div class="modal-body">
                    <?php if(isset($multa)) {
                        //foreach ($multas as $multa) {

                            //if($multa->id_requisicao == 1) {?>
                                <h3><?= Html::encode('Multa: #'.$multa->id_multa) ?></h3>
                                <p><?= Html::encode('Montante: '.$multa->montante).'€' ?></p>
                                <p><?= Html::encode('Estado: '.$multa->estado) ?></p>
                                <p><?= Html::encode('Data: '.$multa->dta_multa) ?></p>

                        <?php //}
                        //}
                    } else { ?>
                        <?= Html::encode('Sem multa.') ?>
                    <?php }?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Fechar', ['class' => 'btn-perfil', 'data-dismiss'=> "modal", 'aria-label'=>"Close"]) ?>
                </div>

            </div>
        </div>
    </div>

</div>
