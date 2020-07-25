<?php

declare(strict_types=1);

namespace slavkluev\JobProgress\models;

use yii\db\ActiveRecord;

class JobProgress extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%job_progress}}';
    }

    public function rules()
    {
        return [
            [['progress_max', 'progress_now'], 'required'],
            [['progress_max', 'progress_now'], 'integer'],
        ];
    }

    public function getProgressMax(): int
    {
        return $this->progress_max;
    }

    public function getProgressNow(): int
    {
        return $this->progress_now;
    }

    public function getPercent(): float
    {
        return $this->getProgressMax() !== 0 ? ($this->getProgressNow() / $this->getProgressMax()) * 100 : 0;
    }

    public static function findIdentityByJob($jobId): JobProgress
    {
        return static::findOne(['job_id' => $jobId]);
    }
}
