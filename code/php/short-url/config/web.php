<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => $db,
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<code:[a-zA-Z0-9]{7}>' => '/short-url/redirect'
            ],
        ],
    ],
];

return $config;
