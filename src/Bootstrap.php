<?php

declare(strict_types=1);

namespace slavkluev\JobProgress;

use yii\base\Application;

class Bootstrap implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        \Yii::setAlias('@slavkluev/JobProgress', __DIR__);
    }
}
