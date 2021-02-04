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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
        'brandLabel' => Html::img('/myLibrary/frontend/web/imgs/diversos/logo_mylibrary_3.png', ['style' => 'width: 70px']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'role' => 'navigation',
        ],
    ]);



    if (Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-home"></span> </div><span style="font-size: 11px" class="menuNav">HOME</span>', 'url' => ['/site/index']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-sign-in-alt"></span> </div><span style="font-size: 11px" class="menuNav">INICIAR SESSÃO</span>', 'url' => ['/site/login']],
        ];
    } else {
        $menuItems = [
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-home"></span> </div><span style="font-size: 11px" class="menuNav">HOME</span>', 'url' => ['/site/index']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-book-open"></span></div> <span style="font-size: 11px" class="menuNav">CATÁLOGO</span>', 'url' => ['/livro/catalogo']],
            ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-archive"></span></div> <span style="font-size: 11px" class="menuNav">REQUISIÇÕES</span>', 'url' => ['/requisicao/index']],
        ];

        if (Yii::$app->user->can('admin')) {

        }


        $user = Yii::$app->user->identity->id;
        $utilizador = Utilizador::find()->where(['id_utilizador' => $user])->one();


        $carrinhoSession = Yii::$app->session->get('carrinho');

        if($carrinhoSession!=null){
            foreach ($carrinhoSession as $livro){
                $items[] = ['label' => '<div style="display: flex"><div class="col-md-10" style="display: flex; margin: 5px">' . Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, ['style' => 'width: 70px'])
                    . ' ' . '<span style="margin-top: 40px; margin-left: 10px; width: 150px; color: white">' . $livro->titulo . '</span></div>'
                    . Html::a(' <span style="margin-right: 10px; font-size: 20px; color: red" class="fas fa-times"></span>', ['carrinho/remover', 'id_livro' => $livro->id_livro]) . '</div>',
                    'url' => ['/livro/detalhes/', 'id' => $livro->id_livro]];
            }
            $items[] = ['label' => '<div class="btnFinalizarRequisicao text-center"><b>Finalizar requisição</b></div>', 'url'=>['/requisicao/finalizar']];
            $menuItems[] = ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-shopping-basket" id="carrinhoLivros"></span></div>
                                       <div class="menuNav"><span style="font-size: 11px">CESTO '.(count($items)-1).'/5</span><span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span></div>', 'items' => $items];

        } else {
            $menuItems[] = ['label' => '<div class="text-center menuNav"><span style="font-size: 20px" class="fas fa-shopping-basket"></span></div><div class="menuNav"><span style="font-size: 11px">CESTO </span><span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span></div>', 'items' =>
                ['label' => '<div class="text-center" style="color: white">CESTO VAZIO</div>']
            ];
        }

        $submenus[] = ['label' => '<i style="width: 20px" class="fas fa-user dropdownMenuIcon"></i> <span class="dropdownMenuText">PERFIL</span>', 'url' => ['/utilizador/perfil']];
        $submenus[] = ['label' => '<i class="fas fa-heart dropdownMenuIcon"></i> <span class="dropdownMenuText">FAVORITOS</span>', 'url' => ['/favorito/index']];
        $submenus[] = ['label' => '<i class="fas fa-sign-out-alt dropdownMenuIcon"></i> <span class="dropdownMenuText" >LOGOUT</span>', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        $menuItems[] = ['label' => '<div class="text-center"><span>' . Html::img(Yii::$app->request->baseUrl . '/imgs/perfil/' . $utilizador->foto_perfil, ['class' => 'imagemPerfil', 'width' => '23px', 'height' => '23px'])
            . '</span></div><div class="menuNav"><span style="font-size: 11px; text-transform: uppercase">' . $utilizador->primeiro_nome
            . ' </span><span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span></div>', 'url' => '', 'items' => $submenus];

    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'dropDownCaret' => '',
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
