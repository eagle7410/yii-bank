<?php

use yii\db\Migration;

/**
 * Handles the creation of table `deposits_history`.
 */
class M170729_184514_DepositsHistory extends Migration
{
    private $tableName = '{{%deposits_history}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'deposit_id' => $this->integer()->notNull(),
            'deposit_operation_id' => $this->integer()->notNull(),
            'sum_before' => $this->double(),
            'sum_change' => $this->double(),
            'percent' => $this->double()->notNull(),
            'comment' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
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
