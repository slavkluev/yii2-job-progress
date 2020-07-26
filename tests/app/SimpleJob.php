<?php

namespace slavkluev\JobProgress\app;

use yii\base\BaseObject;

class SimpleJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        \Yii::$app->queue->setProgressMax(100);
        \Yii::$app->queue->setProgressNow(100);
    }
}
