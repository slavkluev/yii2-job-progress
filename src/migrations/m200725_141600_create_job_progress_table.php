<?php

namespace slavkluev\JobProgress\migrations;

use yii\db\Migration;

class m200725_141600_create_job_progress_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%job_progress}}', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer()->notNull(),
            'progress_max' => $this->integer()->notNull(),
            'progress_now' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%job_progress}}');
    }
}
