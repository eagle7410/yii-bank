<?php

namespace backend\manages\deposits;

use common\models\DepositsSearch;
use yii\data\ActiveDataProvider;

/**
 * Class DepositIndexData
 * @package backend\manages\deposits
 */
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
     * @var ActiveDataProvider
     */
    private $dataProvider;

    /**
     * DepositIndexData constructor.
     *
     * @param DepositsSearch $modelDeposit
     * @param array $userList
     * @param ActiveDataProvider $dataProvider
     */
    public function __construct(DepositsSearch $modelDeposit, array $userList, ActiveDataProvider $dataProvider)
    {
        $this->userList = $userList;
        $this->modelDeposit = $modelDeposit;
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
     * @return DepositsSearch
     */
    public function getModelDeposit()
    {
        return $this->modelDeposit;
    }

    /**
     * @return ActiveDataProvider
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }
}
