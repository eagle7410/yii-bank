<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $data \backend\manages\deposits\DepositIndexData */

$this->title = 'Депозиты';
$this->params['breadcrumbs'][] = $this->title;
$userList = $data->getUserList();
?>
<div class="deposits-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Открыть депозит', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $data->getDataProvider(),
        'filterModel' => $data->getModelDeposit(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'status',
                'value' => 'statusLabel'
            ],
            [
                'attribute' => 'client.fullName',
                'label' => 'ФИО клиента'
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
                'attribute' => 'created_by',
                'value' => function ($row) use ($userList) {
                    return  isset($userList[$row->created_by]) ? $userList[$row->created_by] : $row->created_by;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($row) use ($userList) {
                    if (isset($userList[$row->updated_by])) {
                        return $userList[$row->updated_by];
                    }

                    return empty($row->updated_by) ? 'Система': $row->updated_by;

                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{history} {view} {update} {delete}',
                'buttons' => [
                    'history' => function($url, $row) {
                        $urlHistory = \yii\helpers\Url::toRoute(['deposits-history/index', 'depositId' => $row->id]);

                        return  "<a href='$urlHistory' title='История депозита' aria-label='История депозита'><span class='glyphicon  glyphicon-info-sign'></span></a>";
                    }
                ]
            ],
        ],
    ]); ?>
</div>
