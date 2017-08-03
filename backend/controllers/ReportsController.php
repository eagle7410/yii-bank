<?php

namespace backend\controllers;

use backend\manages\reports\AverageDeposit;
use backend\manages\reports\IncomeCommissions;
use yii\web\Controller;

/**
 * Class ReportsController
 * @package backend\controllers
 */
class ReportsController extends BackendController
{
    /**
     * Report about income and commissions
     *
     * @return string
     */
    public function actionIncomeCommissions()
    {
        $dataManager = new IncomeCommissions();

        return $this->render('income-commissions', ['data' => $dataManager->getData()]);
    }

    /**
     * Report about average deposit split to ages group.
     *
     * @return string
     */
    public function actionAvgDeposits()
    {
        $dataManager = new AverageDeposit();

        return $this->render('avg-deposits', ['data' => $dataManager->getData()]);
    }
}
