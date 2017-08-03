<?php

namespace backend\manages\income_commissions;

use common\models\DepositOperations;
use common\models\Deposits;
use common\models\DepositsHistory;

/**
 * Class DepositsIncomeAndCommissions
 * @package backend\manages\income_commissions
 */
class DepositsIncomeAndCommissions
{
    /**
     * @var bool|\DateTime
     */
    private $dateStart;
    /**
     * @var Deposits[]
     */
    private $deposits;
    /**
     * @var array
     */
    private $result = [
        'income' => [],
        'commission' => []
    ];

    /**
     * IncomeAndCommissions constructor.
     *
     * @param null|\DateTime $date
     */
    public function __construct($date = null)
    {
        if (is_string($date)) {
            $this->dateStart = \DateTime::createFromFormat('Y-m-d', $date);
        } elseif ($date instanceof \DateTime ) {
            $this->dateStart = $date;
        } else {
            $this->dateStart = new \DateTime();
        }

        $this->deposits = Deposits::getForRecalculation();

    }

    /**
     * Calculation deposits income and commissions.
     *
     * @return $this
     */
    public function calculation()
    {
        $income = new DepositsIncome(
            $this->deposits,
            $this->dateStart
        );

        $income->calculation();

        $this->result['income'] = $income->getDepositIncome();

        if ((int)$this->dateStart->format('d') === 1) {
            $commissions = new DepositsCommissions(
                $this->deposits,
                $this->dateStart
            );

            $commissions->calculation();

            $this->result['commission'] = $commissions->getDepositsCommissions();
        }

        return $this;

    }

    /**
     *  Save result calculations.
     */
    public function save()
    {
        $idsIncome = array_keys($this->result['income']);
        $idsCommissions = array_keys($this->result['commission']);

        if (empty($idsIncome) && empty($idsCommissions)) {
            return;
        }

        $depositOperationsCache = [];

        foreach ($this->deposits as $deposit) {

            $isChangeIncome = in_array($deposit->id, $idsIncome);
            $isChangeCommissions = in_array($deposit->id, $idsCommissions);

            if (!$isChangeIncome && !$isChangeCommissions) {
                continue;
            }

            $historyIncome = null;
            $historyCommissions = null;

            $deposit->status = Deposits::STATUS_RUN;

            if ($deposit->sum < 0) {
                $deposit->status = Deposits::STATUS_NO_MONEY;
            }

            if ($isChangeIncome) {
                $historyIncome = new DepositsHistory();
                $historyIncome->sum_change = $this->result['income'][$deposit->id]['sum_change'];
                $historyIncome->sum_before = $this->result['income'][$deposit->id]['sum_before'];
                $historyIncome->deposit_id = $deposit->id;
                $historyIncome->percent = $deposit->percent;

                $alias = DepositOperations::ALIAS_ADD_PERCENT;

                if (!isset($depositOperationsCache[$alias])) {
                    $depositOperationsCache[$alias] = DepositOperations::getIdByAlias($alias);
                }

                $historyIncome->deposit_operation_id = $depositOperationsCache[$alias];
            }

            if ($isChangeCommissions) {
                $historyCommissions = new DepositsHistory();
                $historyCommissions->sum_change = $this->result['commission'][$deposit->id]['sum_change'];
                $historyCommissions->sum_before = $this->result['commission'][$deposit->id]['sum_before'];
                $historyCommissions->deposit_id = $deposit->id;
                $historyCommissions->percent = $deposit->percent;

                $alias = DepositOperations::ALIAS_MINUS_COMMISSIONS;

                if (!isset($depositOperationsCache[$alias])) {
                    $depositOperationsCache[$alias] = DepositOperations::getIdByAlias($alias);
                }

                $historyCommissions->deposit_operation_id = $depositOperationsCache[$alias];
            }

            $transaction = \Yii::$app->db->beginTransaction();

            try {

                if (!$deposit->update(false, ['sum', 'status', 'updated_at', 'updated_by'])) {
                    throw new \Exception("No save deposit \n " . print_r($deposit->attributes, true));
                }

                if ($isChangeIncome && !$historyIncome->save()) {
                    throw new \Exception("No save history income \n " . print_r($historyIncome->attributes, true));
                }

                if ($isChangeCommissions && !$historyCommissions->save()) {
                    throw new \Exception("No save history commissions \n " . print_r($historyCommissions->attributes, true));
                }

                $transaction->commit();

            } catch (\Exception $e) {

                \Yii::error($e->getMessage(), __METHOD__);
                \Yii::error($e->getTraceAsString(), __METHOD__ . '::trace');

                $transaction->rollBack();

            }

        }
    }
}
