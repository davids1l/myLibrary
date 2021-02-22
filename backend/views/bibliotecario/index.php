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

    <h1 class="topicos"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= Html::a('<span class="glyphicon glyphicon-plus" style="margin-bottom: 30px; margin-top: 10px"></span> Inserir Bibliotecário', ['bibliotecario/create'], ['class' => 'btnAcao', 'id' => 'inserirBibliotecario']) ?>

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

            [
                'attribute' => 'primeiro_nome',
                'label' => 'Nome',
            ],
            [
                'attribute' => 'ultimo_nome',
                'label' => 'Apelido',
            ],

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

            [
                'attribute' => 'id_biblioteca',
                'value' => function ($model){
                    if($model->id_biblioteca == null){
                        return '';
                    }else{
                        $nomeBibli = Biblioteca::find()->where(['id_biblioteca' => $model->id_biblioteca])->one();
                        return $nomeBibli->nome;
                    }
                },
                'label' => 'Biblioteca',
            ],

            [
                'attribute' => 'foto_perfil',
                'format' => 'html',
                'filter' => false,
                'value' => function ($dados) {
                     return Html::img(Yii::$app->request->baseUrl . '/../../frontend/web/imgs/perfil/' . $dados['foto_perfil'], ['width' => '60px']);
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

</div>
