<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class ViewsAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/catalogo.css',
        'css/detalhes.css',
        'css/perfil.css',
        'css/historicoRequisicoes'
    ];
    public $js = [
        'js/detalhes.js',
        'js/perfil.js',
        'js/catalogo.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}