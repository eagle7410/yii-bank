<?php
namespace frontend\manages\clients;

use common\models\Clients;
use common\models\User;
use yii\db\Exception;

/**
 * Class ClientShow
 * @package frontend\manages\clients
 */
class ClientShow
{
    /**
     * @var User
     */
    private $modelUser = null;

    /**
     * ClientShow constructor.
     */
    public function __construct()
    {
        $this->modelUser = User::find()
            ->alias('u')
            ->select('username, email, u.id')
            ->joinWith([
                'client' => function ($q) {
                    $q->alias('c')
                        ->select('c.id, personal_number, name, middle_name, surname, user_id')
                        ->one();
                }
            ])
            ->where('u.id = :user', [
                ':user' => \Yii::$app->user->id
            ])
            ->one();

        $this->modelUser->setScenario(User::SCENARIO_CLIENT);

        if ($this->modelUser->client) {
            $this->modelUser->client->setScenario(Clients::SCENARIO_CLIENT);
        }

    }

    public function load($data)
    {
        if (!$this->modelUser->load($data)) {
            return false;
        }

        if ($this->modelUser->client) {
            return $this->modelUser->client->load($data);
        }

        return true;
    }

    public function save()
    {
        if (!$this->modelUser->validate()) {
            \Yii::error('Not valid ' . "\n Errors user:\n" .
                print_r($this->modelUser->errors, true)
                , __METHOD__);
            return false;
        }

        if ($this->modelUser->client && !$this->modelUser->client->validate()) {
            \Yii::error('Not valid ' . "\n Errors client:\n" .
                print_r($this->modelUser->client->errors, true)
                , __METHOD__);
            return false;
        }

        if (!empty($this->modelUser->newPassword)) {
            $this->modelUser->setPassword($this->modelUser->newPassword);
            $this->modelUser->generateAuthKey();
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if (!$this->modelUser->save()) {
                throw new Exception("No update user \n" .
                    print_r($this->modelUser->attributes, true) . "\n Errors:\n" .
                    print_r($this->modelUser->errors, true)
                );
            }

            if ($this->modelUser->client && !$this->modelUser->client->save()) {
                throw new Exception("No update client \n" .
                    print_r($this->modelUser->client->attributes, true) . "\n Errors:\n" .
                    print_r($this->modelUser->client->errors, true)
                );
            }

            $transaction->commit();

            return true;

        } catch (\Exception $e) {

            \Yii::error($e->getMessage(), __METHOD__);
            \Yii::error($e->getTraceAsString(), __METHOD__ .'::trace');

            $transaction->rollBack();

            return false;
        }

    }

    /**
     * @return ClientShowData
     */
    public function getData()
    {
        return new ClientShowData($this->modelUser);
    }
}
