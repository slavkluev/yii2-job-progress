<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@slavkluev/JobProgress', dirname(__DIR__) . '/src');

$config = require(__DIR__ . '/app/config.php');
$app = new \yii\console\Application($config);
