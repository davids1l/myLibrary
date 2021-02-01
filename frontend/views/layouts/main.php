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
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Iniciar Sessão/Registar', 'url' => ['/site/showmodal']],
        ];

    } else {
        $menuItems = [
            ['label' => '<div class="text-center"><span style="font-size: 25px" class="fas fa-home"></span> </div><span style="font-size: 11px">HOME</span>', 'url' => ['/site/index']],
            ['label' => '<div class="text-center"><span style="font-size: 25px" class="fas fa-book-open"></span></div> <span style="font-size: 11px">CATÁLOGO</span>', 'url' => ['/livro/catalogo']],
            ['label' => '<div class="text-center"><span style="font-size: 25px" class="fas fa-archive"></span></div> <span style="font-size: 11px">REQUISIÇÕES</span>', 'url' => ['/requisicao/index']],
        ];

        if (Yii::$app->user->can('admin')) {

        }


        $user = Yii::$app->user->identity->id;
        $utilizador = Utilizador::find()->where(['id_utilizador' => $user])->one();


        $carrinhoSession = Yii::$app->session->get('carrinho');

        if($carrinhoSession!=null){
            foreach ($carrinhoSession as $livro){
                $items[] = ['label' => '<div style="display: flex"><div class="col-md-10" style="display: flex; margin: 5px">' . Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, ['style' => 'width: 70px'])
                    . ' ' . '<span style="margin-top: 40px; margin-left: 10px; width: 150px">' . $livro->titulo . '</span></div>'
                    . Html::a(' <span style="margin-right: 10px; font-size: 20px; color: red" class="fas fa-times"></span>', ['carrinho/remover', 'id_livro' => $livro->id_livro]) . '</div>',
                    'url' => ['/livro/detalhes/', 'id' => $livro->id_livro]];
            }
            $items[] = ['label' => '<b>Finalizar requisição</b>', 'url'=>['/requisicao/finalizar'], 'style'=>'background-color: #b9bbbe', 'class'=>'finalizarRequisicaoCarrinho'];
            $menuItems[] = ['label' => '<div class="text-center"><span style="font-size: 25px" class="fas fa-shopping-basket" id="carrinhoLivros"></span></div>
                                       <span style="font-size: 11px">CESTO </span>'.(count($items)-1).'/5<span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span>', 'items' => $items];

        } else {
            $menuItems[] = ['label' => '<div class="text-center"><span style="font-size: 25px" class="fas fa-shopping-basket"></span></div><span style="font-size: 11px">CESTO </span><span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span>', 'items' =>
                ['label' => '<div class="text-center">Cesto vazio</div>']
            ];
        }

        $submenus[] = ['label' => '<i style="font-size: 20px; width: 20px" class="fas fa-user"></i> Perfil', 'url' => ['/utilizador/perfil']];
        $submenus[] = ['label' => '<i style="font-size: 20px" class="fas fa-heart"></i> Favoritos', 'url' => ['/favorito/index']];
        $submenus[] = ['label' => '<i style="font-size: 20px" class="fas fa-sign-out-alt"></i> Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        $menuItems[] = ['label' => '<div class="text-center"><span>' . Html::img(Yii::$app->request->baseUrl . '/imgs/perfil/' . $utilizador->foto_perfil, ['class' => 'imagemPerfil', 'width' => '28px', 'height' => '28px'])
            . '</span></div><span style="font-size: 11px; text-transform: uppercase">' . $utilizador->primeiro_nome
            . ' </span><span style="font-size: 11px" class="glyphicon glyphicon-menu-down"></span>', 'url' => '', 'items' => $submenus];

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
        <p class="pull-left">&copy; MyLibrary <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
