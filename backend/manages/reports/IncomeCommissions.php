<?php

namespace backend\manages\reports;

use common\models\DepositsHistory;

/**
 * Class IncomeCommissions
 * @package backend\manages\reports
 */
class IncomeCommissions
{
    /**
     * @var array
     */
    private $data;

    /**
     * IncomeCommissions constructor.
     */
    public function __construct()
    {
        $this->getDataFromDb()->formattingData();
    }

    /**
     * Return data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Formatting database data.
     *
     * @return $this
     */
    private function formattingData()
    {
        if (empty($this->data)) {
            return $this;
        }

        $data = [];

        foreach ($this->data as $record) {

            $splitTime = explode('-', $record['season']);

            if (!isset($data[$splitTime[0]])) {
                $data[$splitTime[0]] = [];
            }

            if (!isset( $data[$splitTime[0]][$splitTime[1]] )) {
                $data[$splitTime[0]][$splitTime[1]] = [];
            }

            $data[$splitTime[0]][$splitTime[1]][$record['alias']] = $record['sum'];
        }

        $this->data = $data;

    }

    /**
     * Get data from database.
     *
     * @return $this
     */
    private function getDataFromDb()
    {
        $modelDepositHistory = new DepositsHistory();
        $this->data = $modelDepositHistory->incomeCommissionByMonth();

        return $this;
    }
}
