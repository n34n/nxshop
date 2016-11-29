<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    //'language'  => 'zh',
    'modules' => [
        "ctl" => [
            "class" => "mdm\admin\Module",
        ],
    	'redactor' => [
    		'class' => 'yii\redactor\RedactorModule',
    		'imageAllowExtensions'=>['jpg','png','gif']
    	],
    ],
    'aliases' => [    
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        "authManager" => [        
            "class" => 'yii\rbac\DbManager', //这里记得用单引号而不是双引号        
            "defaultRoles" => ["guest"],    
        ],
        
        'i18n' => [
            'translations' => [
                'backend' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    //'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
/*                     'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ], */
                ],
                'yii' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'en',
                ], 
                'menu' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'en',
                ],                
            ],
        ],

    ],
    'as access' => [
       //ACF肯定是要加的，因为粗心导致该配置漏掉了，很是抱歉
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //这里是允许访问的action
            //controller/action
            '*',
        ]
    ],    
    'params' => $params,
];
