<?php

use yii\db\Migration;
use common\models\User;

class m170801_200513_AddAdmin extends Migration
{
    private $table = '{{%user}}';

    public function safeUp()
    {
        $user = new \common\models\User();
        $user->username = 'admin';
        $user->id = 1;
        $user->status = \common\models\User::STATUS_ACTIVE;
        $user->setPassword('admin1234');
        $user->generateAuthKey();

        $auth = new \yii\rbac\DbManager();

        $roleAdmin = $auth->createRole(User::ROLE_ADMIN);
        $roleEmployee = $auth->createRole(User::ROLE_EMPLOYEE);

        $auth->assign($roleAdmin, 1);
        $auth->assign($roleEmployee, 1);

        return $user->save() ? $user : false;
    }

    public function safeDown()
    {
        $this->delete($this->table);
    }

}
