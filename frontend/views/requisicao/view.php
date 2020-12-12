<?php

use app\models\Livro;
use app\models\RequisicaoLivro;
use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Requisição #' . $model->id_requisicao;
//$this->params['breadcrumbs'][] = ['label' => 'Requisicaos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="requisicao-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <!--<p>
        <? /*= Html::a('Update', ['update', 'id' => $model->id_requisicao], ['class' => 'btn btn-primary']) */ ?>
        <? /*= Html::a('Delete', ['delete', 'id' => $model->id_requisicao], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>-->

    <table class="tableHistRequisicoes">
        <tr class="tableHistRequisicoes">
            <th class="tableHistRequisicoes">Data de levantamento</th>
            <th class="tableHistRequisicoes">Data de entrega</th>
            <th class="tableHistRequisicoes">Estado</th>
            <?php $nrLivros = RequisicaoLivro::find()->where(['id_requisicao' => $model->id_requisicao])->count(); ?>
            <th class="tableHistRequisicoes" colspan="<?= $nrLivros ?>">Livros Requisitados</th>
        </tr>
        <tr class="tableHistRequisicoes">
            <th class="tableHistRequisicoes"><h4><?= Carbon::parse(Html::encode($model->dta_levantamento))->format('d/m/Y H:i:s'); ?></h4></th>
            <th class="tableHistRequisicoes"><h4><?= Carbon::parse(Html::encode($model->dta_entrega))->format('d/m/Y H:i:s'); ?></h4></th>
            <th class="tableHistRequisicoes"><h4><?= Html::encode($model->estado); ?></h4></th>
            <?php
            $livros = RequisicaoLivro::find()->where(['id_requisicao' => $model->id_requisicao])->all();

            foreach ($livros as $livro) {
                $detalhesLivro = Livro::find()->where(['id_livro' => $livro->id_livro])->one(); ?>

                <th class="tableHistRequisicoes"><h4><?= $detalhesLivro->titulo ?> <br>
                        de <?= $detalhesLivro->autor->nome_autor ?> <br><br>
                        <a href="<?= Url::to(['livro/detalhes', 'id' => $livro->id_livro]) ?>">
                            <?= Html::img($detalhesLivro->capa, ['width' => 120]) ?>
                        </a></h4></th>
            <?php } ?>
        </tr>
    </table>
</div>
