<?php

namespace backend\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;

class BackendController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_EMPLOYEE],
                    ],
                ],
            ],
        ];
    }

}
