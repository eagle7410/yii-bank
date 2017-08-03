<?php
namespace console\controllers;

use backend\manages\income_commissions\DepositsIncomeAndCommissions;
use common\models\CronRunHistory;
use yii\console\Controller;

/**
 * Class CronController
 * @package console\controllers
 */
class CronController extends Controller
{
    /**
     * Adding income percent to deposits and remove commissions.
     */
    public function actionIncomeCommissions ()
    {
        $starrAt = new \DateTime();

        if (!$this->checkRunsToday($starrAt, CronRunHistory::TYPE_INCOME_COMMISSIONS)) {
            return false;
        }

        $IncomeAndCommissions = new DepositsIncomeAndCommissions($starrAt);
        $IncomeAndCommissions->calculation()->save();
    }

    /**
     * Check run cron be one in day.
     *
     * @param $starrAt \DateTime
     * @param $cronType int
     *
     * @return bool
     */
    private function checkRunsToday($starrAt, $cronType)
    {
        $cronHistory = new CronRunHistory();
        $cronHistory->cron_start_at = $starrAt->getTimestamp();
        $cronHistory->cron_type = $cronType;

        $countRunToday = $cronHistory->countRunToday();

        if ($countRunToday > 0 || !$cronHistory->save()) {
            \Yii::error("Cron run today or no save start ",__METHOD__);
            \Yii::error("-- count cron run today {$countRunToday} ",__METHOD__);
            \Yii::error("-- cron run history attributes ". print_r($cronHistory->attributes, true),__METHOD__);
            \Yii::error("-- cron run history errors ". print_r($cronHistory->errors, true),__METHOD__);

            return false;
        }

        return true;
    }
}
