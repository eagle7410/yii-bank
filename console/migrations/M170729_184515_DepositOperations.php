<?php

use yii\db\Migration;

/**
 * Handles the creation of table `money_operations`.
 */
class M170729_184515_DepositOperations extends Migration
{
    private $tableName = '{{%deposit_operations}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'alias' => $this->string(100)->notNull(),
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
