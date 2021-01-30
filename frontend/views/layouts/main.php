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
        'brandLabel' => 'MyLibrary',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'role' => 'navigation',
        ],
    ]);

    //$menuItems = [
    //    ['label' => 'Home', 'url' => ['/site/index']],
    //    ['label' => 'Catálogo', 'url' => ['/livro/catalogo']],
    //    //['label' => 'Perfil', 'url' => ['/utilizador/perfil']],
    //    ['label' => 'Requisições', 'url' => ['/requisicao/index']],
    //];

    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Registar', 'url' => ['/site/signup']];
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Iniciar Sessão/Registar', 'url' => ['/site/showmodal']],
        ];

    } else {
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Catálogo', 'url' => ['/livro/catalogo']],
            //['label' => 'Perfil', 'url' => ['/utilizador/perfil']],
            ['label' => 'Requisições', 'url' => ['/requisicao/index']],
        ];

        if (Yii::$app->user->can('admin')) {

        }


        $user = Yii::$app->user->identity->id;
        $utilizador = Utilizador::find()->where(['id_utilizador' => $user])->one();


        $carrinhoSession = Yii::$app->session->get('carrinho');

        if($carrinhoSession!=null){
            foreach ($carrinhoSession as $livro){
                $items[] = ['label' => Html::img('/myLibrary/backend/web/imgs/capas/' . $livro->capa, ['style' => 'width: 50px']).' '.$livro->titulo, 'url' => ['/livro/detalhes/', 'id' => $livro->id_livro]];
            }
            $items[] = ['label' => '<b>Finalizar requisição</b>', 'url'=>['/requisicao/finalizar'], 'style'=>'background-color: #b9bbbe', 'class'=>'finalizarRequisicaoCarrinho'];
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-shopping-cart badge" id="carrinhoLivros">'.(count($items)-1).'/5</span>', 'url' => '', 'items' => $items];

        } else {
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>', 'url' => '', 'items' =>
                ['label' => '<i>Carrinho vazio</i>']
            ];
        }

        $submenus[] = ['label' => '<i class="fas fa-user-circle"></i> Perfil', 'url' => ['/utilizador/perfil']];
        $submenus[] = ['label' => '<i class="fab fa-gratipay"></i> Favoritos', 'url' => ['/favorito/index']];
        $submenus[] = ['label' => '<i class="fas fa-sign-out-alt"></i> Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        $menuItems[] = ['label' => $utilizador->primeiro_nome . '&nbsp ' . Html::img(Yii::$app->request->baseUrl . '/imgs/perfil/' . $utilizador->foto_perfil, ['class' => 'imagemPerfil', 'width' => '20px', 'height' => '20px']), 'url' => '', 'items' => $submenus];

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

    echo "<form class='navbar-form navbar-left' role='search'>
           <div class='form-group has-feedback'>
                <input id='searchbox' type='text' placeholder='Search' class='form-control'>
                <span id='searchicon' class='fa fa-search form-control-feedback'></span>
            </div>
         </form>";

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
