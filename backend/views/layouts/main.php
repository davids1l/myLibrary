<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('/myLibrary/frontend/web/imgs/diversos/logo_mylibrary_3.png', ['style' => 'width: 70px']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'role' => 'navigation',
        ],
    ]);


    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-sign-in-alt"></span> </div><span style="font-size: 11px" class="menuNav">INICIAR SESSÃO</span>', 'url' => ['/site/login']];
    } else {

        $submenusdiversos[] = ['label' => 'Editoras', 'url' => ['editoras/index']];
        $submenusdiversos[] = ['label' => 'Autores', 'url' => ['autores/index']];

        $menuItems = [
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-home"></span> </div><span style="font-size: 11px" class="menuNav">HOME</span>', 'url' => ['/site/index']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-book-open"></span> </div><span style="font-size: 11px" class="menuNav">LIVROS</span>', 'url' => ['/livros/index']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="far fa-user"></span> </div><span style="font-size: 11px" class="menuNav">LEITORES</span>', 'url' => ['/utilizador/index']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-archive"></span></div> <span style="font-size: 11px" class="menuNav">REQUISIÇÕES</span>', 'url' => ['/requisicao/index']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-receipt"></span></div> <span style="font-size: 11px" class="menuNav">MULTAS</span>', 'url' => ['/multa/index']],
            ['label' => '<div class="text-center"><div class="menuNav"><span style="font-size: 20px" class="fas fa-cog"></span></div> <div class="menuNav"><span style="font-size: 11px" class="menuNav">DIVERSOS </span><span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span></div></div>', 'url' => '', 'items' => $submenusdiversos],
        ];

        if (Yii::$app->user->can('admin')) {
            $menuItems[] = ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-user-tie"></span></div> <span style="font-size: 11px" class="menuNav">BIBLIOTECÁRIOS</span>', 'url' => ['/bibliotecario/index']];
            $menuItems[] = ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-university"></span></div> <span style="font-size: 11px" class="menuNav">BIBLIOTECAS</span>', 'url' => ['/bibliotecas/index']];
        }


        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton('<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-sign-out-alt"></span></div> <span style="font-size: 11px" class="menuNav">LOGOUT</span>',['class' => 'btn btn-link logout'])
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'dropDownCaret' => '',
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container" style="width: 90%">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <?= Html::img('/myLibrary/frontend/web/imgs/diversos/logo_mylibrary_3.png', ['style' => 'width: 70px; margin-bottom: 30px']) ?>
                <p class="footerBranco"><i class="far fa-copyright"></i> MyLibrary <?= date('Y') ?></p>
            </div>

            <div class="col-md-4"></div>

            <div class="col-md-4" style="margin-top: 10px">
                <p class="footerTitulos text-center"><i class="fas fa-terminal" style="margin-right: 3px"></i> Desenvolvedores</p>
                <div class="footerDesenvolvedores">
                    <p>Afonso Cancela</p>
                    <p>David Silvério</p>
                    <p>Tiago Lopes</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
