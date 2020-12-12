<?php

use app\models\RequisicaoLivro;
use Carbon\Carbon;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequisicaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histórico de Requisicões';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <!--<p>
        <?/*= Html::a('Create Requisicao', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if($requisicoes == null){ ?>
        <h4>Não tem nenhuma requisição</h4>
    <?php }else{ ?>
        <table class="tableHistRequisicoes">
            <tr class="tableHistRequisicoes">
                <th class="tableHistRequisicoes">ID</th>
                <th class="tableHistRequisicoes">Data de Levantamento</th>
                <th class="tableHistRequisicoes">Data de Entrega</th>
                <th class="tableHistRequisicoes">Nº de Livros</th>
                <th class="tableHistRequisicoes">Estado</th>
            </tr>
            <?php
            foreach ($requisicoes as $requisicao) { ?>
                <tr class="tableHistRequisicoes">
                    <th class="tableHistRequisicoes"><h4><?= Html::encode($requisicao->id_requisicao); ?></h4></th>
                    <th class="tableHistRequisicoes"><h4><?= Carbon::parse(Html::encode($requisicao->dta_levantamento))->format('d/m/Y H:i:s'); ?></h4></th>
                    <th class="tableHistRequisicoes"><h4><?= Carbon::parse(Html::encode($requisicao->dta_entrega))->format('d/m/Y H:i:s'); ?></h4></th>
                    <?php $nrLivros = RequisicaoLivro::find()->where(['id_requisicao' => $requisicao->id_requisicao])->count(); ?>
                    <th class="tableHistRequisicoes"><h4><?=  $nrLivros ?></h4></th>
                    <th class="tableHistRequisicoes"><h4><?= Html::encode($requisicao->estado); ?></h4></th>
                    <th class="tableHistRequisicoes"><?= Html::a('<i class="glyphicon glyphicon-eye-open">', ['requisicao/view', 'id' => $requisicao->id_requisicao]) ?></th>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</div>
