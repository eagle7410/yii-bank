<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DepositsHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $depositId int | null */

$this->title = 'История изменения депозита номер '. $depositId;
$this->params['breadcrumbs'][] = ['label' => 'Депозиты', 'url' => ['site/deposits']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="deposits-history-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Назад', ['site/deposits'], ['class' => 'btn btn-info']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' =>'operation.name',
                'label' => 'Операция'
            ],
            [
                'attribute' => 'sum_before',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asCurrency($row->sum_before);
                }
            ],
            [
                'attribute' => 'sum_change',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asCurrency($row->sum_change);
                }
            ],
            [
                'attribute' => 'percent',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asPercent($row->percent);
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->created_at);
                }
            ],
        ],
    ]); ?>
</div>
