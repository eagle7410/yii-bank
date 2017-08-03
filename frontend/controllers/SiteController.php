<?php
namespace frontend\controllers;

use common\models\DepositsHistorySearch;
use frontend\manages\clients\ClientShow;
use frontend\manages\deposits\DepositIndex;
use Yii;
use yii\di\Container;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays personal data.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $container = new Container();
        $dataManager = $container->get(ClientShow::class);

        if ($dataManager->load(\Yii::$app->request->post()) && $dataManager->save()) {
            \Yii::$app->session->setFlash('success', 'Изменения были внесены');
            return $this->redirect('index');
        }

        return $this->render('index', ['data' => $dataManager->getData()]);
    }

    /**
     * Displays client deposits info.
     *
     * @return string
     */
    public function actionDeposits() {
        $container = new Container();
        $dataManager = $container->get(DepositIndex::class);

        return $this->render('deposits', ['data' => $dataManager->getData()]);
    }

    /**
     * Display deposit history.
     *
     * @param int $depositId
     *
     * @return string
     */
    public function actionDepositHistory(int $depositId)
    {
        $searchModel = new DepositsHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $depositId);

        return $this->render('deposit-history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'depositId' => $depositId
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $this->layout = "main-login";

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
