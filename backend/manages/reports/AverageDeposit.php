<?php

namespace backend\manages\reports;

use common\models\Deposits;
use yii\helpers\ArrayHelper;

/**
 * Class AverageDeposit
 * @package backend\manages\reports
 */
class AverageDeposit
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
     * Formatting database data.
     *
     * @return $this
     */
    private function formattingData()
    {
        $this->data = ArrayHelper::map($this->data, 'age_group', 'sum');

        return $this;
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
     * Get data from database.
     *
     * @return $this
     */
    private function getDataFromDb()
    {
        $modelDeposit = new Deposits();
        $this->data = $modelDeposit->getAvarageDepositSumByClientAgeGroup();

        return $this;
    }
}
