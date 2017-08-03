<?php

use yii\db\Migration;

class m170801_200511_InsertDateForDepositOpretions extends Migration
{
    private $table = '{{%deposit_operations}}';
    public function safeUp()
    {
        $this->batchInsert($this->table, ['id', 'name' , 'alias'], [
            [1, 'Создание депозита', 'create'],
            [2, 'Ручное изменения депозита', 'changeEmployee'],
            [3, 'Начислены проценты', 'addPercent'],
            [4, 'Сняты комиссионные', 'minusCommissions'],
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->table);
    }

}
