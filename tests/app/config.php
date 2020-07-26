<?php

return [
    'id' => 'yii2-job-progress-test',
    'basePath' => __DIR__,
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(__DIR__) . '/runtime',
    'bootstrap' => ['queue'],
    'components' => [
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'mutex' => \yii\mutex\FileMutex::class,
            'as progress' => \slavkluev\JobProgress\ProgressBehavior::class,
        ],
        'queueDelete' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'mutex' => \yii\mutex\FileMutex::class,
            'as progress' => [
                'class' => \slavkluev\JobProgress\ProgressBehavior::class,
                'deleteAfterExecution' => true,
            ],
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'sqlite:@runtime/yii2_queue_test.db',
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'yii\queue\db\migrations',
                'slavkluev\JobProgress\migrations',
            ],
        ],
    ],
];
