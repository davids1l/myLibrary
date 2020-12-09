<?php

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
        <table>
            <tr>
                <th>id_requisicao</th>
                <th>dta_levantamento</th>
                <th>dta_entrega</th>
                <th>estado</th>
                <th>id_livro</th>
            </tr>
            <?php
            foreach ($requisicoes as $requisicao) { ?>
                <tr>
                    <th><h4><?= Html::encode($requisicao->id_requisicao); ?></h4></th>
                    <th><h4><?= Carbon::parse(Html::encode($requisicao->dta_levantamento))->format('d/m/Y H:i:s'); ?></h4></th>
                    <th><h4><?= Carbon::parse(Html::encode($requisicao->dta_entrega))->format('d/m/Y H:i:s'); ?></h4></th>
                    <th><h4><?= Html::encode($requisicao->estado); ?></h4></th>
                    <th><h4><?= Html::encode($requisicao->id_livro); ?></h4></th>
                    <th><?= Html::a('Ver Requisição', ['requisicao/view', 'id' => $requisicao->id_requisicao]) ?></th>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>



</div>
