<?php

namespace frontend\manages\deposits;

use common\models\DepositsSearch;

class DepositIndexData
{
    /**
     * @var DepositsSearch
     */
    private $modelDeposit;
    /**
     * @var array
     */
    private $userList;
    /**
     * @var \yii\data\ActiveDataProvider
     */
    private $dataProvider;

    public function __construct($modelDeposit, $userList, $dataProvider)
    {
        $this->userList = $userList;
        $this->modelDeposit = $modelDeposit;
        $this->dataProvider = $dataProvider;
    }

    public function getUserList()
    {
        return $this->userList;
    }

    public function getModelDeposit()
    {
        return $this->modelDeposit;
    }

    public function getDataProvider()
    {
        return $this->dataProvider;
    }
}
