<?php

namespace frontend\manages\clients;

use common\models\User;

/**
 * Class ClientShowData
 * @package frontend\manages\deposits
 */
class ClientShowData
{
    /**
     * @var User
     */
    private $modelUser;

    /**
     * ClientCreateUpdateData constructor.
     *
     * @param User $modelUser
     */
    public function __construct(
        User &$modelUser
    )
    {
        $this->modelUser = $modelUser;
    }

    /**
     * @return User
     */
    public function getModelUser()
    {
        return $this->modelUser;
    }

}
