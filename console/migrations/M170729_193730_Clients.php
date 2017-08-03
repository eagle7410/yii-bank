<?php

use yii\db\Migration;

/**
 * Handles the creation of table `clients`.
 */
class M170729_193730_Clients extends Migration
{
    private $tableName = '{{%clients}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'personal_number' => $this->integer()->notNull()->unique(),
            'name' => $this->string(100),
            'middle_name' => $this->string(100),
            'surname' => $this->string(150),
            'birthday' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'is_man' => $this->boolean()->notNull(),
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
