<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=carzcomu_tangle',
            'username' => 'carzcomu_tangle',
            'password' => '.]e$0uS07p$q',
            'charset' => 'utf8',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'messageConfig' => [
                'from' => ['info@tangle.fund' => 'Info'],
                'charset' => 'UTF-8',
            ]
        ],

        /*'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
                'username' => 'username',
                'password' => 'password',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],*/

    ],
];
