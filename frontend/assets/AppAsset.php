<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/perfil.css',
        'css/historicoRequisicoes',
        'fontawesome-free-5.15.2-web/css/all.css'
    ];
    public $js = [
        'js/site_index.js',
        'js/perfil.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
