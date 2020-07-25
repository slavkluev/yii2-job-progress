<?php

declare(strict_types=1);

namespace slavkluev\JobProgress;

use slavkluev\JobProgress\models\JobProgress;
use yii\base\Behavior;
use yii\queue\ExecEvent;
use yii\queue\Queue;

class ProgressBehavior extends Behavior
{
    public $progressMax = 10;
    public $progressNow = 0;
    public $deleteAfterExecution = false;

    /**
     * @var JobProgress
     */
    protected $jobProgress;

    public function events()
    {
        return [
            Queue::EVENT_BEFORE_EXEC => function (ExecEvent $event) {
                $this->jobProgress = new JobProgress([
                    'job_id' => $this->owner->getPrimaryKey(),
                    'progress_max' => $this->progressMax,
                    'progress_now' => $this->progressNow,
                ]);
                $this->jobProgress->save();
            },
            Queue::EVENT_AFTER_EXEC => function (ExecEvent $event) {
                if ($this->deleteAfterExecution) {
                    $this->jobProgress->delete();
                }
            },
        ];
    }

    /**
     * @param int $value
     *
     * @throws \Throwable
     */
    protected function setProgressMax(int $value)
    {
        $this->update(['progress_max' => $value]);
    }

    /**
     * @param int $value
     *
     * @throws \Throwable
     */
    protected function setProgressNow(int $value)
    {
        $this->update(['progress_now' => $value]);
    }

    /**
     * @param int $offset
     *
     * @throws \Throwable
     */
    protected function incrementProgress(int $offset = 1)
    {
        $value = $this->getProgressNow() + $offset;
        $this->setProgressNow($value);
    }

    /**
     * @param $attributes
     *
     * @throws \Throwable
     */
    protected function update($attributes)
    {
        $this->jobProgress->setAttributes($attributes);
        $this->jobProgress->update();
    }

    protected function getProgressMax()
    {
        return $this->jobProgress->getProgressMax();
    }

    protected function getProgressNow()
    {
        return $this->jobProgress->getProgressNow();
    }
}
