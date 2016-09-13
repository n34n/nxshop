<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
        	'class' => 'yii\rbac\DbManager',
        ],
        'log' => [
            //'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' =>
            [
                'db' => [
                    'class' => 'backend\components\DbTarget',//'yii\log\DbTarget',
                    'levels' => ['trace'],
                    //'except' => ['*index'],
                    'categories' => ['yii\base\Controller::runAction'],
                ]
            ],
        ],        
    ],
];
