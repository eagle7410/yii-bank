<?php

namespace backend\manages\income_commissions;

use common\models\Deposits;

/**
 * Class DepositsCommissions
 * @package backend\manages\income_commissions
 */
class DepositsCommissions
{
    /**
     * @var Deposits[]
     */
    private $deposits;
    /**
     * @var \DateTime
     */
    private $dateStart;
    /**
     * @var int
     */
    private $monthBefore;
    /**
     * @var int
     */
    private $yearBefore;
    /**
     * @var array
     */
    private $depositsCommissions = [];
    /**
     * @var array
     */
    private $rules = [
        ['min' => 0, 'max' => 1000, 'percent' => 0.05 , 'minValue' => 50],
        ['min' => 1000, 'max' => 10000, 'percent' => 0.06],
        ['min' => 10000, 'percent' => 0.07 , 'maxValue' => 5000],
    ];

    /**
     * DepositsIncome constructor.
     *
     * @param $deposits Deposits[]
     * @param $date \DateTime
     */
    public function __construct(&$deposits, \DateTime &$date)
    {
        $this->deposits = $deposits;
        $this->dateStart = $date;
        $this->monthBefore = (int) $date->format('m') - 1;
        $this->yearBefore = (int) $date->format('Y');

        if ($this->monthBefore === 0) {
            $this->yearBefore--;
            $this->monthBefore = 12;
        }

    }

    /**
     * Calculation commissions.
     */
    public function calculation()
    {
        foreach ($this->deposits as $deposit) {

            foreach ($this->rules as $rule) {

                if (
                    ($deposit->sum < $rule['min']) ||
                    (isset($rule['max']) && $rule['max'] <= $deposit->sum)
                ) {
                    continue;
                }

                $commissions = $deposit->sum * $rule['percent'];

                $dateStartDeposit = new \DateTime();
                $dateStartDeposit->setTimestamp((int) $deposit->start_at);

                if (isset($rule['minValue']) && $rule['minValue'] > $commissions) {
                    $commissions = $rule['minValue'];
                } elseif (isset($rule['maxValue']) && $rule['maxValue'] < $commissions) {
                    $commissions = $rule['maxValue'];
                }

                if (
                    (int) $dateStartDeposit->format('m') === $this->monthBefore &&
                    (int) $dateStartDeposit->format('Y') === $this->yearBefore
                ) {
                    $daysInMonth = (int) $dateStartDeposit->format('t');
                    $workDays = $daysInMonth - (int) $dateStartDeposit->format('d') + 1;
                    $commissions *= $workDays/$daysInMonth;
                }

                $this->depositsCommissions[$deposit->id] = [
                    'sum_before' => $deposit->sum,
                    'sum_change' => 0 - $commissions
                ];

                $deposit->sum -= $commissions;

            }

        }
    }

    /**
     * Return deposits commissions.
     *
     * @return array
     */
    public function getDepositsCommissions()
    {
        return $this->depositsCommissions;
    }
}
