<?php

namespace backend\controllers;

use backend\manages\clients\ClientCreateUpdate;
use backend\manages\clients\ClientIndex;
use common\models\Deposits;
use Yii;
use common\models\Clients;
use common\models\User;
use yii\di\Container;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends BackendController
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
     * Lists all Clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $container = new Container();
        $dataManager = $container->get(ClientIndex::class);

        return $this->render('index', ['data' => $dataManager->getData()]);
    }

    /**
     * Displays a single Clients model.
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
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->save('create');
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->save('update', $id);
    }

    /**
     * Deletes an existing Clients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $modelUser = User::find()->joinWith('client')->where(['clients.id' => $id])->one();

        if (!empty($modelUser)) {

            $transaction = \Yii::$app->db->beginTransaction();

            try {

                if (!Deposits::updateAll(
                        ['status' => Deposits::STATUS_OWNER_DELETE],
                        'client_id = :id',
                        [':id' => $id]
                    )
                ) {
                    throw new \Exception("No set status 'owner delete' to deposits for client #{$id}");
                }

                $modelUser->status = User::STATUS_DELETED;

                if (!$modelUser->save()) {
                    throw new \Exception("No set status 'delete' for client #{$id}");
                }

                $transaction->commit();

            } catch (\Exception $e) {

                \Yii::error($e->getMessage(), __METHOD__);
                \Yii::error($e->getTraceAsString(), __METHOD__ .'::trace');

                $transaction->rollBack();

                return false;
            }


        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function save($render, $clientId = null)
    {
        $container = new Container();
        $dataManager = $container->get(ClientCreateUpdate::class, [$clientId]);

        if ($dataManager->load(Yii::$app->request->post()) && $dataManager->save()) {
            return $this->redirect(['view', 'id' => $dataManager->getClientId()]);
        }

        return $this->render($render, ['data' => $dataManager->getData()]);
    }
}
