<?php
$config = [
    'homeUrl'=>Yii::getAlias('@rbacUrl'),
    'controllerNamespace' => 'rbac\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [

    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
             'baseUrl' => '',
            'cookieValidationKey' => env('RBAC_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'identityClass' => 'rbac\models\User',
            'enableAutoLogin' => true,
        ],
        'db' => require(__DIR__ . '/db.php'),
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'generators'=>[
            'crud'=>[
                'class'=>'yii\gii\generators\crud\Generator',
                'messageCategory'=>'frontend'
            ]
        ]
    ];
}

return $config;
