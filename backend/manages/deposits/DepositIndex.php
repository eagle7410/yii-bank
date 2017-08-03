<?php

namespace backend\manages\deposits;

use common\models\DepositsSearch;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * Class DepositIndex
 * @package backend\manages\deposits
 */
class DepositIndex
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

    /**
     * DepositIndex constructor.
     *
     * @param DepositsSearch $modelDeposit
     * @param User $user
     */
    public function __construct(
        DepositsSearch $modelDeposit,
        User $user
    )
    {
        $this->modelDeposit = $modelDeposit;

        $this->dataProvider = $this->modelDeposit->search(\Yii::$app->request->queryParams);

        $this->userList = ArrayHelper::map($user->getList(), 'id', 'username');

    }

    /**
     * @return DepositIndexData
     */
    public function getData()
    {
        return new DepositIndexData($this->modelDeposit, $this->userList, $this->dataProvider);
    }
}
