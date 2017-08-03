<?php

namespace backend\manages\clients;

use common\models\Clients;
use common\models\User;

class ClientCreateUpdateData
{
    /**
     * @var Clients
     */
    private $modelClient;
    /**
     * @var User
     */
    private $modelUser;

    /**
     * ClientCreateUpdateData constructor.
     *
     * @param Clients $modelClient
     * @param User $modelUser
     */
    public function __construct(
        Clients &$modelClient,
        User &$modelUser
    )
    {
        $this->modelClient = $modelClient;
        $this->modelUser = $modelUser;
    }

    /**
     * @return User
     */
    public function getModelUser()
    {
        return $this->modelUser;
    }

    /**
     * @return Clients
     */
    public function getModelClient()
    {
        return $this->modelClient;
    }
}
