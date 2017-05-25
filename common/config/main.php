<?php

return [
    'name' => 'Tangle',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'urlManager' => [
        		//'class' => 'yii\web\UrlManager',
        		'enablePrettyUrl' => true,
        		'showScriptName' => false
        ],
/*
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets'
        ],
*/

        'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],

    ],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        ],
    ],

];
