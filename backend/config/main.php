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
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => \backend\models\User::class,
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => \yii\rbac\PhpManager::class,
            'ruleFile' => '@backend/config/rbac/rules.php',
            'itemFile' => '@backend/config/rbac/items.php',
            'assignmentFile' => '@backend/config/rbac/assignments.php',
            'defaultRoles' => ['admin', 'content'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'pattern' => 'user/index/<year:(\d{4}|-1)>/<letter:([A-ZА-ЯЁ]|ALL)>/<page>',
                    'route' => 'user/index',
                    'defaults' => ['page' => 1, 'letter' => 'ALL', 'year' => -1],
                ],
            ]
        ],
    ],
    'params' => $params,
];
