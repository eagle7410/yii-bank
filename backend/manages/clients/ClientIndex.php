<?php

namespace backend\manages\clients;

use common\models\ClientsSearch;
use common\models\User;
use yii\helpers\ArrayHelper;

class ClientIndex
{
    /**
     * @var ClientsSearch
     */
    private $modelClient;
    /**
     * @var array
     */
    private $userList;
    /**
     * @var \yii\data\ActiveDataProvider
     */
    private $dataProvider;

    public function __construct(
        ClientsSearch $modelClient,
        User $user
    )
    {
        $this->modelClient = $modelClient;

        $this->dataProvider = $this->modelClient->search(\Yii::$app->request->queryParams);

        $this->userList = ArrayHelper::map($user->getList(), 'id', 'username');

    }

    /**
     * @return ClientIndexData
     */
    public function getData()
    {
        return new ClientIndexData($this->modelClient, $this->userList, $this->dataProvider);
    }
}
