<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=rdsnnamnbnnamnbprivate.mysql.rds.aliyuncs.com;dbname=blog',
            'username' => 'maxwelldu',
            'password' => 'yu13jiu14',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
