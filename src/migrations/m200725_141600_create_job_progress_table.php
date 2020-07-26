<?php

namespace slavkluev\JobProgress\migrations;

use yii\db\Migration;

class m200725_141600_create_job_progress_table extends Migration
{
    public $tableName = '{{%job_progress}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer()->notNull(),
            'progress_max' => $this->integer()->notNull(),
            'progress_now' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('job_id', $this->tableName, 'job_id');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
