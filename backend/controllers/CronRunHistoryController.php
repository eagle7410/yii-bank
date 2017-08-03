<?php

namespace backend\controllers;

use Yii;
use common\models\CronRunHistory;
use common\models\CronRunHistorySearch;

/**
 * CronRunHistoryController implements the CRUD actions for CronRunHistory model.
 */
class CronRunHistoryController extends BackendController
{
    /**
     * Lists all CronRunHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CronRunHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChangeIgnore ($id) {
        $model = CronRunHistory::findOne($id);

        if ($model) {
            $model->start_ignore = !$model->start_ignore;
            $model->save();
        }

        $this->redirect('index');
    }
}
