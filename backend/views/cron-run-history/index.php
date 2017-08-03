<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CronRunHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История стартов кронов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-run-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cronLabel',
            [
                'attribute' => 'cron_start_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDatetime($row->cron_start_at);
                }
            ],
            [
                'attribute' => 'start_ignore',
                'content' => function ($row) {

                    if ($row->start_ignore) {
                        $status = 'Да';
                        $event = 'Не игнорировать';
                    } else {
                        $status = 'Нет';
                        $event = 'Игнорировать';
                    }

                    return $status . ' ' . Html::a($event,['change-ignore', 'id' => $row->id]);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDatetime($row->updated_at);
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($row) {
                    return  $row->user ? $row->user->username : 'Система';
                }
            ]
        ],
    ]); ?>
</div>
