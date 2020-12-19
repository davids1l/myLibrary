<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\models\Utilizador;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

//'brandLabel' => Yii::$app->name,
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'MyLibrary',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Catálogo', 'url' => ['/livro/catalogo']],
        //['label' => 'Perfil', 'url' => ['/utilizador/perfil']],
        ['label' => 'Requisições', 'url' => ['/requisicao/index']],
    ];
    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Registar', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Iniciar Sessão/Registar', 'url' => ['/site/showmodal']];

    } else {

        if(Yii::$app->user->can('admin')){

        }


        $user = Yii::$app->user->identity->id;
        $utilizador = Utilizador::find()->where(['id_utilizador' => $user])->one();


        $carrinhoSession = Yii::$app->session->get('carrinho');

        if($carrinhoSession!=null){
            foreach ($carrinhoSession as $livro){
                $items[] = ['label' => Html::img($livro->capa, ['id' => 'imgCapa', 'style' => 'width: 50px']).' '.$livro->titulo, 'url' => '../livro/detalhes?id='.$livro->id_livro];
                $items[] = ['label' => '<hr style="margin: 0;>'];
            }
            $items[] = ['label' => '<b>Finalizar requisição</b>', 'url'=>'../requisicao/finalizar'];
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>', 'url' => '', 'items' => $items];

        } else {
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>', 'url' => '', 'items' =>
                ['label' => '<h4>Carrinho vazio</h4>', 'url' => '']
            ];
        }

        $submenus[] = ['label' => 'Perfil', 'url' => ['/utilizador/perfil']];
        $submenus[] = ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        $menuItems[] = ['label' => $utilizador->primeiro_nome . '&nbsp ' . Html::img(Yii::$app->request->baseUrl . '/imgs/perfil/' . $utilizador->foto_perfil, ['class' => 'imagemPerfil', 'width'=>'20px', 'height' => '20px']), 'url' => '', 'items' => $submenus];

        //$menuItems[] = '<li>'
        //    . Html::beginForm(['/site/logout'], 'post')
        //    . Html::submitButton('Logout (' . $utilizador->primeiro_nome . " " . $utilizador->ultimo_nome . ')', ['class' => 'btn btn-link logout'])
        //    . Html::endForm()
        //    . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
