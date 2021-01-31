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
        'css/historicoRequisicoes.css'
    ];
    public $js = [
        'js/detalhes.js',
        'js/catalogo.js',
        //'js/site_index.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}