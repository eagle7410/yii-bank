<?php
namespace backend\manages\clients;

use common\models\Clients;
use common\models\User;

/**
 * Class ClientCreateUpdate
 * @package backend\manages\clients
 */
class ClientCreateUpdate
{
    /**
     * @var Clients
     */
    private $modelClient;
    /**
     * @var User
     */
    private $modelUser = null;
    /**
     * @var bool
     */
    private $isNew = false;
    /**
     * ClientCreateUpdate constructor.
     *
     * @param null $clientId
     * @param Clients $modelClient
     */
    public function __construct(
        $clientId = null,
        Clients $modelClient
    )
    {
        if (!$clientId) {
            $this->modelUser = new User();
            $this->modelClient = $modelClient;
            $this->modelClient->personal_number = time();
            $this->isNew = true;
        } else {
            $this->modelClient = $modelClient->getById($clientId);
            $this->modelUser = $this->modelClient->user;
        }

    }

    /**
     * Load data to models from request.
     * @param $data
     *
     * @return bool
     */
    public function load($data)
    {
        return $this->modelClient->load($data) && $this->modelUser->load($data);
    }

    /**
     * Save models.
     *
     * @return bool
     */
    public function save()
    {

        if ($this->isNew && empty($this->modelUser->newPassword)) {
            $this->modelUser->addError('newPassword', 'Для создания нового клиента обязатель указывать его пароль');

            return false;
        }

        if (!$this->modelUser->validate() || !$this->modelClient->validate()) {
            return false;
        }

        if (!empty($this->modelUser->newPassword)) {
            $this->modelUser->setPassword($this->modelUser->newPassword);
            $this->modelUser->generateAuthKey();
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {

            if (!$this->modelUser->save()) {
                return false;
            }

            $this->modelClient->user_id = $this->modelUser->id;

            if (!$this->modelClient->save()) {
                return false;
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
     * @return int
     */
    public function getClientId()
    {
        return $this->modelClient->id;
    }

    /**
     * @return ClientCreateUpdateData
     */
    public function getData()
    {
        return new ClientCreateUpdateData($this->modelClient, $this->modelUser);
    }
}
