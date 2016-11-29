<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    		'css/bootstrap-select.css'
    ];
    public $js = [
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'js/bootbox.js',
    	'js/bootstrap-select.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
