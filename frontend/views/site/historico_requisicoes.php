<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


use yii\console\widgets\Table;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;

$this->title = 'Histórico de Requisições';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h1><?= Html::encode($this->title) ?></h1><br><br>

            <?php
            $arr=array(1=>"one", 2=>"two", 3=>"three");
            ?>

            <?= GridView::widget([
                'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
                'filterModel' => $arr,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    '1',
                    '2',
                    '3',


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>


<!--            <table style="width: 100%">-->
<!--                <tr>-->
<!--                    <th>Capa</th>-->
<!--                    <th>Título</th>-->
<!--                    <th>Data da requisição</th>-->
<!--                    <th>Data da entrega</th>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Imagem</td>-->
<!--                    <td>Os Lusíadas</td>-->
<!--                    <td>10/10/2020</td>-->
<!--                    <td>19/10/2020</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Imagem</td>-->
<!--                    <td>Os Lusíadas</td>-->
<!--                    <td>10/10/2020</td>-->
<!--                    <td>19/10/2020</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Imagem</td>-->
<!--                    <td>Os Lusíadas</td>-->
<!--                    <td>10/10/2020</td>-->
<!--                    <td>19/10/2020</td>-->
<!--                </tr>-->
<!--            </table>-->
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
