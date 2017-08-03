<?php

use yii\db\Migration;

/**
 * Handles the creation of table `deposits`.
 */
class M170729_193731_Deposits extends Migration
{
    private $tableName = '{{%deposits}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'sum' => $this->double(),
            'percent' => $this->double(),
            'status' => $this->integer(2)->notNull()->defaultValue(0),
            'start_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
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
