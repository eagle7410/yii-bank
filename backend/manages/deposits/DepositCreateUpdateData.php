<?php
namespace backend\manages\deposits;

use common\models\Deposits;

/**
 * Class DepositCreateUpdateData
 * @package backend\manages\deposits
 */
class DepositCreateUpdateData
{
    /**
     * @var Deposits
     */
    private $modelDeposits;
    /**
     * @var array
     */
    private $clientList;

    /**
     * DepositCreateUpdateData constructor.
     *
     * @param Deposits $modelDeposits
     * @param array $clientList
     */
    public function __construct(
        Deposits $modelDeposits,
        array $clientList
    ) {
        $this->modelDeposits = $modelDeposits;
        $this->clientList = $clientList;
    }

    /**
     * @return array
     */
    public function getClientList()
    {
        return $this->clientList;
    }

    /**
     * @return Deposits
     */
    public function getModelDeposits()
    {
        return $this->modelDeposits;
    }
}
