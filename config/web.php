<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'modules' => [
        'admin' => [
            'class' => 'yiiapps\adminlte\Module',
            'layout' => 'main',
            'menus' => [
                // 'assignment' => [
                //     'label' => 'Grant Access', // change label
                // ],
                // 'route' => null, // disable menu
            ],
            // 'mainLayout' => '@vendor/yiiapps/adminlte-asset-ext/views/layouts/main.php',
        ],
    ],
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@yiiapps/adminlte' => '@vendor/yiiapps/adminlte-asset-ext',
    ],
    'name' => '静态文件管理',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cookieValidationKeycookieValidationKeycookieValidationKey',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['admin/user/login'],
            // 'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views/adminlte' => '@vendor/yiiapps/adminlte-asset-ext/views',
                ],
            ],
        ],
        's3' => [
            'class' => 'frostealth\yii2\aws\s3\Service',
            'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
                'key' => 'AKIAOFNRM6QC6WI3JNKQ',
                'secret' => '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',
            ],
            'region' => 'cn-north-1',
            'defaultBucket' => 'tiensmalltest',
            'defaultAcl' => 'public-read',
        ],
        'assetManager' => [
            'bundles' => [
                // 'yii\web\JqueryAsset' => false,
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null, // 一定不要发布该资源
                    'js' => [
                        'http://libs.baidu.com/jquery/1.10.2/jquery.min.js',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            // 'site/*',
            // 'gii/*',
            // 'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ],
    ],
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'defaultRoute' => 'admin',
    'layout' => '@vendor/yiiapps/adminlte-asset-ext/views/layouts/main.php',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
