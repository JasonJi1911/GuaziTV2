<?php
define('ROOT_PATH', dirname(dirname(__DIR__))); // 项目根目录

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'setting' => 'common\services\Setting',
        'apps' => 'common\services\Apps',
    ],
];
