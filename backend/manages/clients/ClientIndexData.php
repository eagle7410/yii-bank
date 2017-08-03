<?php

namespace backend\manages\clients;

use common\models\ClientsSearch;

class ClientIndexData
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

    public function __construct($modelClient, $userList, $dataProvider)
    {
        $this->userList = $userList;
        $this->modelClient = $modelClient;
        $this->dataProvider = $dataProvider;
    }

    /**
     * @return array
     */
    public function getUserList()
    {
        return $this->userList;
    }

    /**
     * @return ClientsSearch
     */
    public function getModelClient()
    {
        return $this->modelClient;
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }
}
