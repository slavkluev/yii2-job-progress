<?php

declare(strict_types=1);

namespace slavkluev\JobProgress;

use PHPUnit\Framework\TestCase;
use slavkluev\JobProgress\app\EmptyJob;
use slavkluev\JobProgress\app\IterationJob;
use slavkluev\JobProgress\app\SimpleJob;
use slavkluev\JobProgress\models\JobProgress;
use stdClass;
use Yii;

class JobProgressTest extends TestCase
{
    public function testDefaultValues()
    {
        $jobId = Yii::$app->queue->push(new EmptyJob());
        Yii::$app->queue->run(false);
        $jobProgress = JobProgress::findByJobId($jobId);
        $this->assertEquals(0, $jobProgress->getProgressNow());
        $this->assertEquals(10, $jobProgress->getProgressMax());
        $this->assertEquals(0, $jobProgress->getPercent());
    }

    public function testCompleteJob()
    {
        $jobId = Yii::$app->queue->push(new SimpleJob());
        Yii::$app->queue->run(false);
        $jobProgress = JobProgress::findByJobId($jobId);
        $this->assertEquals(100, $jobProgress->getProgressNow());
        $this->assertEquals(100, $jobProgress->getProgressMax());
        $this->assertEquals(100, $jobProgress->getPercent());
    }

    public function testDeleteProgressAfterExec()
    {
        $jobId = Yii::$app->queueDelete->push(new EmptyJob());
        Yii::$app->queueDelete->run(false);
        $jobProgress = JobProgress::findByJobId($jobId);
        $this->assertNull($jobProgress);
    }
}
