<?php

/* @var $this yii\web\View */
/* @var $data frontend\manages\deposits\DepositIndexData */

$this->title = 'Депозиты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $data->getDataProvider(),
        'filterModel' => $data->getModelDeposit(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'status',
                'value' => 'statusLabel'
            ],
            [
                'attribute' => 'sum',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asCurrency($row->sum);
                }
            ],
            [
                'attribute' => 'percent',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asPercent($row->percent);
                }
            ],
            [
                'attribute' => 'start_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->start_at);
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->updated_at);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{history}',
                'buttons' => [
                    'history' => function($url, $row) {
                        $urlHistory = \yii\helpers\Url::toRoute(['site/deposit-history', 'depositId' => $row->id]);

                        return  "<a href='$urlHistory'>История депозита</a>";
                    }
                ]
            ],
        ],
    ]); ?>
</div>
