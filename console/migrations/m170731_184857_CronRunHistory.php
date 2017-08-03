<?php

use yii\db\Migration;

class m170731_184857_CronRunHistory extends Migration
{
    private $tableName = '{{%cron_run_history}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'cron_type' => $this->integer()->notNull(),
            'cron_start_at' => $this->integer()->notNull(),
            'start_ignore' => $this->boolean()->defaultValue(false),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo $this->dropTable($this->tableName);
    }
}
