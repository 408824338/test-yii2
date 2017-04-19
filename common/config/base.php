<?php

$config = [
    'name' => 'Yii2 Starter Kit',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
//    'sourceLanguage'=>'en-US',
    'sourceLanguage' => 'zh-CN',
//    'language'=>'en-US',
    'language' => 'zh-CN',
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Chongqing',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}',
        ],
        'lookup' => [
//            'class' => 'zacksleo\yii2\lookup\models\Lookup',
            'class' => 'common\components\Lookup',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'commandBus' => [
            'class' => 'trntv\bus\CommandBus',
            'middlewares' => [
                [
                    'class' => '\trntv\bus\middlewares\BackgroundCommandMiddleware',
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY'),
        ],
        'imageCache' => [
            'class' => 'iutbay\yii2imagecache\ImageCache',
            'sourcePath' => '@storage/web/source',
            'sourceUrl' => '@storage/cache',
            //'thumbsPath' => '@app/web/thumbs',
            //'thumbsUrl' => '@web/thumbs',
            //'sizes' => [
            // 'thumb' => [150, 150],
            //    'medium' => [300, 300],
            //    'large' => [600, 600],
            //],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            //'useFileTransport' => true,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => env('ADMIN_EMAIL'),
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php',
                        'company' => 'company.php',
                    ],
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation'],
                ],
                /* Uncomment this code to use DbMessageSource
                  '*'=> [
                  'class' => 'yii\i18n\DbMessageSource',
                  'sourceMessageTable'=>'{{%i18n_source_message}}',
                  'messageTable'=>'{{%i18n_message}}',
                  'enableCaching' => YII_ENV_DEV,
                  'cachingDuration' => 3600,
                  'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                  ],
                 */
            ],
        ],
        'fileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@storage/web/source',
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage',
            ],
        ],
        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage',
        ],
        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@backendUrl'),
            ], require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerCompany' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@companyUrl'),
            ], require(Yii::getAlias('@company/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@frontendUrl'),
            ], require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@storageUrl'),
            ], require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),
        'sms' => [
            'class' => 'ihacklog\sms\Sms',
            'provider' => YII_ENV_PROD ? 'Yuntongxun' : 'File', //set default provider
            'verifyTemplateId' => 150294,
            'services' => [
                'Yuntongxun' => [
                    'class' => 'ihacklog\sms\provider\Yuntongxun',
                    'apiUrl' => 'https://app.cloopen.com:8883',
//                'apiUrl' => 'https://sandboxapp.cloopen.com:8883',
                    'templateId' => 150294,
                    'appId' => '8a216da856c131340156d3ff1bb60d47',
                    'accountSid' => '8a216da856c131340156d3ff1b280d40',
                    'accountToken' => '9068a167e6254ae49fbf516e0a3dfffe',
                    'softVersion' => '2013-12-26',
                ],
                'File' => [
                    'class' => 'ihacklog\sms\provider\File',
                    'templateId' => 1,
                ],
            ],
        ],
        'rsa' => [
            'class' => 'ihacklog\rsa\RSA',
            'publicKey' => $vendorDir . '/ihacklog/yii2-rsa/tests/_data/rsa/p2p20140616.cer',
            'privateKey' => $vendorDir . '/ihacklog/yii2-rsa/tests/_data/rsa/p2p20140616.pem',
            'services' => [
                'OpensslRSA' => [
                    'class' => ihacklog\rsa\OpensslRSA::class,
                ],
            ],
        ],
        'mycomponent' => [
            'class' => 'common\components\MyComponent',
            'terry' => 'xxxx',
        ],

    ],
    'modules' => [
        //modules测试
        'report' => [
            'class' => 'frontend\modules\report\Module',
            'components' => [
                'mycomponent' => [
                    'class' => 'common\components\MyComponent',
                    'terry' => 'xxxx',
                ],
            ],
            'params' => [
                'water' => 'good',
            ],
        ],
        'sms' => [
            'class' => 'ihacklog\sms\Module',
            'userModelClass' => '\common\models\User', // optional. your User model. Needs to be ActiveRecord.
            'resendTimeSpan' => YII_ENV_PROD ? 60 : 10, //重发时间间隔(单位：秒）
            'singleIpTimeSpan' => YII_ENV_PROD ? 3600 : 0, //单个ip用于统计允许发送的最多次数的限定时间
            'singleIpSendLimit' => YII_ENV_PROD ? 20 : 0, //单个ip在限定的时间内允许发送的最多次数
            'verifyTimeout' => 300, //验证码超时(秒)
            'enableHttpsCertVerify' => YII_ENV_PROD ? true : false, //是否校验https证书,线上环境建议启用
        ],
    ],
    'params' => [
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'availableLocales' => [
            'en-US' => 'English (US)',
            'ru-RU' => 'Русский (РФ)',
            'uk-UA' => 'Українська (Україна)',
            'es' => 'Español',
            'zh-CN' => '简体中文',
        ],
        'pageSize' => [
            'manage' => 10,
            'user' => 10,
            'product' => 10,
            'frontproduct' => 9,
            'order' => 10,
        ],

    ],
];

if (YII_ENV_PROD) {
    $config['components']['log']['targets']['email'] = [
        'class' => 'yii\log\EmailTarget',
        'except' => ['yii\web\HttpException:*'],
        'levels' => ['error', 'warning'],
        'message' => ['from' => env('ROBOT_EMAIL'), 'to' => env('ADMIN_EMAIL')],
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [//生成器名称 
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [//设置我们自己的模板 
                    //模板名 => 模板路径 
                    'myCrud' => '@app/../common/components/gii-custom/crud/default',
                ],
            ],
            'model' => [//生成器名称 
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [//设置我们自己的模板 
                    //模板名 => 模板路径 
                    'myModel' => '@app/../common/components/gii-custom/model/default',
                ],
            ],
        ],
    ];

    $config['components']['cache'] = [
        'class' => 'yii\caching\DummyCache',
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
    ];
}

return $config;
