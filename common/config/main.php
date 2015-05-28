<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => '\yii\caching\MemCache',
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
//        'session' => [
//            'class' => '\yii\web\CacheSession',
//            'cache' => 'cache',
//        ],
    ],
    'language' => 'zh-CN',
];
