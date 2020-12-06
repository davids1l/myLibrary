<?php

/* @var $this \yii\web\View */
/* @var $content string */

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

    Yii::$app->session->get('carrinho');

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'Catálogo', 'url' => ['/livro/catalogo']],
        ['label' => 'Biblioteca', 'url' => ['/biblioteca/index']],
    ];



    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];

    } else {

        if(Yii::$app->user->can('admin')){

        }

        $carrinhoSession = Yii::$app->session->get('carrinho');

        if(isset($carrinhoSession)){
            foreach ($carrinhoSession as $livro){
                $items[] = ['label' => Html::img($livro->capa, ['id' => 'imgCapa', 'style' => 'width: 20%']).' '.$livro->titulo, 'url' => '../livro/detalhes?id='.$livro->id_livro];
            }
            $items[] = ['label' => '<i>Finalizar requisição</i>', 'url'=>'requisicao/index'];
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>', 'url' => '', 'items' => $items];

        } else {
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>', 'url' => '', 'items' =>
                ['label' => '<h4>Carrinho vazio</h4>', 'url' => '']
            ];
        }


        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
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
