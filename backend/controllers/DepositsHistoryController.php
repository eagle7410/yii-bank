<?php

namespace backend\controllers;

use Yii;
use common\models\DepositsHistorySearch;

/**
 * DepositsHistoryController implements the CRUD actions for DepositsHistory model.
 */
class DepositsHistoryController extends BackendController
{
     /**
     * Display deposits history models.
     * @return mixed
     */
    public function actionIndex()
    {
        $depositId = \Yii::$app->request->get('depositId');

        $searchModel = new DepositsHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $depositId);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'depositId' => $depositId
        ]);
    }

}
