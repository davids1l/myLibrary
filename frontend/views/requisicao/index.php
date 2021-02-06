<?php

use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequisicaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histórico de Requisições';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>
    <hr>-->

    <?php if($requisicoes != null) { ?>
    <h3 class="topicos" style="padding-left: 0">CANCELAR REQUISIÇÃO</h3>
    <div class="reqs_cancelar" style="margin-bottom: 5%;">
        <?php foreach ($requisicoes as $req) { ?>
            <div class="col-xs-12 col-md-4 req_por_levantar" style="background-color: #fafafa; border: 1px solid grey; border-radius: 2px; max-width: 370px; margin: 5px; height: 204px;">
                <div class="col-md-12">
                    <div style="display: inline-flex">
                        <h4>Requisição: #<?= $req->id_requisicao ?></h4>
                        <div style="margin-left: 100%; text-align: right; padding: 10px">
                            <?= Html::a('<i class="fas fa-trash-alt"></i>', ['requisicao/delete', 'id' => $req->id_requisicao],
                                ['id' => 'cancelarReq', 'title' => 'Cancelar Requisição', 'data' => ['confirm' => 'Deseja cancelar a requisição?', 'method' => 'post']]) ?>
                        </div>
                    </div>
                    <hr>
                    <p><b>Bib. levantamento:</b> <?= $req->biblioteca->nome ?></p>
                    <p><b>Estado:</b> <?= $req->estado ?></p>
                    <?= Html::a('Ver livros', ['requisicao/view', 'id' => $req->id_requisicao]) ?>
                </div>
                <!-- <div class="col-md-2" style="padding-top: 6px; padding-left: 30px;">

                </div> -->
            </div>
        <?php } ?>
    </div>
    <?php } ?>


    <h3 class="topicos" style="padding-left: 0">REQUISIÇÕES</h3>
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
                'format' => 'html',
                'value' => function ($model) {
                    return RequisicaoLivro::find()->where(['id_requisicao' => $model->id_requisicao])->count();
                }
            ],
            [
                //'attribute' => 'dta_levantamento',
                'label' => 'Data de Levantamento',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_levantamento)->format('d-m-Y H:i');
                },
            ],
            [
                //'attribute' => 'dta_entrega',
                'label' => 'Data de Entrega',
                'value' => function ($model) {
                    return Carbon::parse($model->dta_entrega)->format('d-m-Y H:i');
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
                'template' => '{view} {multa} {cancelar}',
                'buttons' => [
                    'view' => function ($url, $dataProvider, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['requisicao/view', 'id'=> $key]);
                    },
                    'multa' => function ($key, $model) {

                        //encontrar a multa com o id requisicao = id requisicao do model
                        $multa = \frontend\models\Multa::find()->where(['id_requisicao' => $model->id_requisicao])->one();

                        if (isset($multa)) {
                            return Html::a('<span class="glyphicon glyphicon-exclamation-sign" style="color: #c9302c"></span>', ['requisicao/showmultamodal', 'key' => $key, 'id_requisicao' => $model->id_requisicao]);
                        }
                    },
                    'cancelar' => function ($key, $model) {

                        if($model->estado == 'Pronta a levantar' || $model->estado == 'A aguardar tratamento'){
                            return Html::a('<span class="" style="color: #c9302c">Cancelar</span>',  ['requisicao/delete', 'id' => $model->id_requisicao],
                                ['id' => 'cancelarReqGrid', 'title' => 'Cancelar Requisição', 'data' => ['confirm' => 'Deseja cancelar a requisição?', 'method' => 'post']]);
                        }
                    }
                ]
            ],
        ],
    ]); ?><hr>



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
                    <?php if(isset($multa)) { ?>
                        <h3><?= Html::encode('Multa: #'.$multa->id_multa) ?></h3>
                        <p><?= Html::encode('Montante: '.$multa->montante).'€' ?></p>
                        <p><?= Html::encode('Estado: '.$multa->estado) ?></p>
                        <p><?= Html::encode('Data de emissão: '.$multa->dta_multa) ?></p>
                    <?php } else { ?>
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
