<?php

namespace backend\manages\income_commissions;

use common\models\Deposits;

/**
 * Class DepositsIncome
 * @package backend\manages\income_commissions
 */
class DepositsIncome
{
    /**
     * @var Deposits[]
     */
    private $deposits;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var bool
     */
    private $isNowLastDayMonth;
    /**
     * @var array
     */
    private $depositsIncome = [];

    /**
     * DepositsIncome constructor.
     *
     * @param $deposits Deposits[]
     * @param $date \DateTime
     */
    public function __construct(&$deposits, &$date)
    {
        $dateLastOfMonth = clone $date;
        $dateLastOfMonth->modify('last day of this month');

        $this->deposits = $deposits;
        $this->date = $date;
        $this->isNowLastDayMonth = $this->date->format('d-m-Y') === $dateLastOfMonth->format('d-m-Y');
    }

    /**
     * Calculation income by percent.
     */
    public function calculation()
    {
        foreach ($this->deposits as $deposit) {
            $dateDepositStart = new \DateTime();
            $dateDepositStart->setTimestamp((int) $deposit->start_at);

            if (
                (
                    $this->isNowLastDayMonth &&
                    ((int) $this->date->format('d') < (int) $dateDepositStart->format('d'))
                ) ||
                ($this->date->format('d') === $dateDepositStart->format('d'))
            )
            {
                $income = (float) $deposit->sum * (float) $deposit->percent;

                $this->depositsIncome[$deposit->id] = [
                    'sum_before' => $deposit->sum,
                    'sum_change' => $income
                ];

                $deposit->sum += $income;
            }

        }
    }

    /**
     * Return deposits income.
     *
     * @return array
     */
    public function getDepositIncome()
    {
        return $this->depositsIncome;
    }
}
