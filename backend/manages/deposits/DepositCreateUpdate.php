<?php
namespace backend\manages\deposits;

use common\models\DepositOperations;
use common\models\Deposits;
use common\models\Clients;
use common\models\DepositsHistory;
use yii\helpers\ArrayHelper;

/**
 * Class DepositCreateUpdate
 * @package backend\manages\deposits
 */
class DepositCreateUpdate
{
    /**
     * @var Deposits
     */
    private $modelDeposits;
    /**
     * @var array
     */
    private $clientList;

    public function __construct(
        $depositId = null,
        Deposits $modelDeposits,
        Clients $modelClient
    ) {
        if ($depositId) {
            $this->modelDeposits = $modelDeposits->getById($depositId);
            $this->modelDeposits->setScenario(Deposits::SCENARIO_UPDATE);
        } else {
            $this->modelDeposits = $modelDeposits;
        }

        $this->clientList = ArrayHelper::map($modelClient->getActiveList(), 'id', 'full_name');
    }

    /**
     * Load data to models from request.
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function load($data)
    {
        return $this->modelDeposits->load($data);
    }

    /**
     * Save models.
     *
     * @return bool
     */
    public function save()
    {
        $history = new DepositsHistory();

        $oldSum = $this->modelDeposits->getOldAttribute('sum');
        $oldSum = empty($oldSum) ? 0 : $oldSum;

        $history->sum_before = $oldSum;
        $history->sum_change = $this->modelDeposits->sum - $oldSum;
        $history->percent = $this->modelDeposits->percent;

        $isNew = $this->modelDeposits->isNewRecord;
        $isSaveHistory = !empty(array_diff($this->modelDeposits->getOldAttributes(), $this->modelDeposits->getAttributes()));

        if ($isNew) {
            $history->deposit_operation_id = DepositOperations::getIdByAlias(DepositOperations::ALIAS_CREATE);
        } elseif ($isSaveHistory) {
            $history->deposit_operation_id = DepositOperations::getIdByAlias(DepositOperations::ALIAS_UPDATE_EMPLOYEE);
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {

            if (!$this->modelDeposits->save()) {
                \Yii::error("No save deposit \n ".
                    print_r($this->modelDeposits->attributes, true) . "\nErrors:\n" .
                    print_r($this->modelDeposits->errors, true)
                    , __METHOD__
                );

                return false;
            }

            if ($isSaveHistory || $isNew) {
                $history->deposit_id = $this->modelDeposits->id;

                if (!$history->save()) {
                    \Yii::error("No save deposit history \n ".
                        print_r($history->attributes, true) . "\nErrors:\n" .
                        print_r($history->errors, true),
                        __METHOD__
                    );

                    return false;
                }
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
    public function getId()
    {
        return $this->modelDeposits->id;
    }

    /**
     * @return DepositCreateUpdateData
     */
    public function getData()
    {
        return new DepositCreateUpdateData(
            $this->modelDeposits,
            $this->clientList
        );
    }
}
