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
        'css/perfil.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}