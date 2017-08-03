<?php

use yii\db\Migration;
use common\models\User;

class m170801_200512_AddRoles extends Migration
{
    public function safeUp()
    {
        $auth = new \yii\rbac\DbManager();
        $auth->init();

        $role = $auth->createRole(User::ROLE_ADMIN);
        $auth->add($role);

        $role = $auth->createRole(User::ROLE_EMPLOYEE);
        $auth->add($role);
    }

    public function safeDown()
    {
        echo "m170729_165218_AddRoles cannot be reverted.\n";
    }

}
