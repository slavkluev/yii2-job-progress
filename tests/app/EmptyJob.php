<?php

namespace slavkluev\JobProgress\app;

use yii\base\BaseObject;

class EmptyJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
    }
}
