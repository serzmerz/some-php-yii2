<?php
namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\View;

class TangleAsset extends  AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'http://fonts.googleapis.com/css?family=Roboto:300,400,700',
        'https://fonts.googleapis.com/css?family=Montserrat:400,700',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'css/style.blue.css',
        'css/custom.css'
    ];

    public $js = [
        'js/jquery.cookie.js',
        'js/owl.carousel.min.js',
        'js/front.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'frontend\assets\FontAwesomeAsset'
    ];

    public $jsOptions = [
      'position' =>  View::POS_END,
    ];

}