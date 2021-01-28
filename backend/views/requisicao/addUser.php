<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

$this->title = 'Adicionar leitor - Requisição';
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$utilizadorSession = Yii::$app->session->get('dadosUser');
?>
<div class="requisicao-add-user">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rowAddBook">
        <div class="row" style="display: flex; justify-content: center; align-items: center;">

            <div class="col-md-7">
                <?php $form = ActiveForm::begin([
                    'id' => 'pesquisa-form',
                    'options' => ['class' => 'form-horizontal'],
                    'action' => ['requisicao/add-user']
                ]) ?>

                <?= $form->field($searchModel, 'numero')->label('Indique o número de leitor: '); ?>
            </div>
            <div class="col-md-5" style="display: flex; justify-content: left; align-items: center;">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Pesquisar', ['className' => 'pesquisa', 'class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end() ?>
                <br/>
            </div>
        </div>
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>
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
                            <p>Parece que não foram encontrados dados relativos a esse utilizador.</p>
                        <?php } ?>
                    </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

