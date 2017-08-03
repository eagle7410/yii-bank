<?php

use yii\db\Migration;

class m170801_193227_AddCascadeDelete extends Migration
{
    private $tableUsers = '{{%user}}';

    private $tableClients = '{{%clients}}';

    private $tableDeposits = '{{%deposits}}';

    private $tableDepositsHistory = '{{%deposits_history}}';

    public function safeUp()
    {
        $this->createIndex(
            'idx-clients-user_id',
            $this->tableClients,
            'user_id'
        );

        $this->addForeignKey(
            'clients-user_id',
            $this->tableClients,
            'user_id',
            $this->tableUsers,
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-deposits-client_id',
            $this->tableDeposits,
            'client_id'
        );

        $this->addForeignKey(
            'deposits-client_id',
            $this->tableDeposits,
            'client_id',
            $this->tableClients,
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-deposits_history-deposit_id',
            $this->tableDepositsHistory,
            'deposit_id'
        );

        $this->addForeignKey(
            'deposits_history-deposit_id',
            $this->tableDepositsHistory,
            'deposit_id',
            $this->tableDeposits,
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('deposits_history-deposit_id', $this->tableDepositsHistory);
        $this->dropIndex('idx-deposits_history-deposit_id', $this->tableDepositsHistory);

        $this->dropForeignKey('deposits-client_id', $this->tableDeposits);
        $this->dropIndex('idx-deposits-client_id', $this->tableDeposits);

        $this->dropForeignKey('clients-user_id', $this->tableClients);
        $this->dropIndex('idx-clients-user_id', $this->tableClients);
    }

}
