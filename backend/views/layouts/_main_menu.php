<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */

NavBar::begin([
    'brandLabel' => Yii::$app->params['brandLabel'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        [
            'label' => 'Клиенты',
            'url' => ['/clients/index']
        ],
        [
            'label' => 'Депозиты',
            'items' => [
                [
                    'label' => 'Депозиты',
                    'url' => ['/deposits/index']
                ],
                [
                    'label' => 'История изменения депозтов',
                    'url' => ['/deposits-history/index']
                ],
                [
                    'label' => 'Операций с депозитами',
                    'url' => ['/deposit-operations/index']
                ],
            ]

        ],
        [
            'label' => 'Отчеты',
            'items' => [
                [
                    'label' => 'Начислений и комиссий',
                    'url' => ['/reports/income-commissions']
                ],
                [
                    'label' => 'Средняя сумма депозита',
                    'url' => ['/reports/avg-deposits']
                ],
            ]

        ],
        [
            'label' => 'Кроны',
            'items' => [
                [
                    'label' => 'История стартов кронов',
                    'url' => ['/cron-run-history/index']
                ],
            ]

        ],
        [
            'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'class' => 'btn btn-link logout'
        ],
    ],
]);
NavBar::end();
