<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$commonComponents = require(__DIR__ . '/../../common/config/components.php');
$commonModules = require(__DIR__ . '/../../common/config/modules.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' =>
        array_merge(
            $commonComponents,
            [
                'request' => [
                    'csrfParam' => '_csrf-frontend',
                    'baseUrl' => '',
                ],
                'user' => [
                    'identityClass' => 'common\models\User',
                    'enableAutoLogin' => true,
                    'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
                ],
                'session' => [
                    // this is the name of the session cookie used for login on the frontend
                    'name' => 'advanced-frontend',
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
                'errorHandler' => [
                    'errorAction' => 'site/error',
                ]

            ]
        ),
    'modules' => $commonModules,
    'params' => $params,
];
