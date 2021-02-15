<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class ViewsAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'css/catalogo.css',
        'css/detalhes.css',
        'css/perfil.css',
        'css/historicoRequisicoes.css',
        'fontawesome-free-5.15.2-web/css/all.css'
    ];
    public $js = [
        'js/detalhes.js',
        'js/catalogo.js',
        'js/favoritos.js',
        //'js/site_index.js'
        'js/perfil.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}