<?php

declare(strict_types=1);

namespace slavkluev\JobProgress;

use slavkluev\JobProgress\models\JobProgress;
use yii\base\Behavior;
use yii\queue\ExecEvent;
use yii\queue\Queue;

class ProgressBehavior extends Behavior
{
    /**
     * The default value of max number of progress.
     *
     * @var int
     */
    public $progressMax = 10;

    /**
     * The default value of current number of progress.
     *
     * @var int
     */
    public $progressNow = 0;

    /**
     * The parameter is responsible for removing the progress after job execution.
     *
     * @var bool
     */
    public $deleteAfterExecution = false;

    /**
     * @var JobProgress
     */
    protected $jobProgress;

    public function events()
    {
        return [
            Queue::EVENT_BEFORE_EXEC => 'beforeExec',
            Queue::EVENT_AFTER_EXEC => 'afterExec',
        ];
    }

    public function beforeExec(ExecEvent $event)
    {
        $this->jobProgress = new JobProgress([
            'job_id' => $event->id,
            'progress_max' => $this->progressMax,
            'progress_now' => $this->progressNow,
        ]);
        $this->jobProgress->save();
    }

    public function afterExec(ExecEvent $event)
    {
        if ($this->deleteAfterExecution) {
            $this->jobProgress->delete();
        }
    }

    /**
     * @return int
     */
    public function getProgressMax(): int
    {
        return $this->jobProgress->getProgressMax();
    }

    /**
     * @return int
     */
    public function getProgressNow(): int
    {
        return $this->jobProgress->getProgressNow();
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->jobProgress->getPercent();
    }

    /**
     * Update the max number of progress.
     *
     * @param int $value
     */
    public function setProgressMax(int $value)
    {
        $this->update(['progress_max' => $value]);
    }

    /**
     * Update the current number of progress.
     *
     * @param int $value
     */
    public function setProgressNow(int $value)
    {
        $this->update(['progress_now' => $value]);
    }

    /**
     * Increase current number of progress by $offset.
     *
     * @param int $offset
     */
    public function incrementProgress(int $offset = 1)
    {
        $value = $this->getProgressNow() + $offset;
        $this->setProgressNow($value);
    }

    /**
     * @param array $attributes
     */
    protected function update(array $attributes)
    {
        $this->jobProgress->setAttributes($attributes);
        $this->jobProgress->update();
    }
}
