<?php

namespace backend\controllers;

use backend\manages\deposits\DepositIndex;
use Yii;
use common\models\Deposits;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\di\Container;
use backend\manages\deposits\DepositCreateUpdate;

/**
 * DepositsController implements the CRUD actions for Deposits model.
 */
class DepositsController extends BackendController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Deposits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $container = new Container();
        $dataManager = $container->get(DepositIndex::class);

        return $this->render('index', ['data' => $dataManager->getData()]);
    }

    /**
     * Displays a single Deposits model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Deposits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->save('create');
    }

    /**
     * Updates an existing Deposits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->save('update', $id);
    }

    /**
     * Deletes an existing Deposits model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Deposits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deposits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Deposits::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function save($render, $depositId = null)
    {
        $container = new Container();
        $dataManager = $container->get(DepositCreateUpdate::class, [$depositId]);

        if ($dataManager->load(Yii::$app->request->post()) && $dataManager->save()) {
            return $this->redirect(['view', 'id' => $dataManager->getId()]);
        }

        return $this->render($render, ['data' => $dataManager->getData()]);
    }
}
