<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DepositsHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $depositId int | null */

$arColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'deposit_id',
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
    [
        'attribute' => 'created_by',
        'value' => function ($row) {
            return empty($row->user->username) ? 'Система': $row->user->username;
        }
    ],
    'comment',

];

if ($depositId) {
    $this->title = 'История изменения депозита номер '. $depositId;
    $this->params['breadcrumbs'][] = ['label' => 'Депозиты', 'url' => ['deposits/index']];
    $this->params['breadcrumbs'][] = $this->title;
    $arColumns = array_diff($arColumns, ['deposit_id']);
} else {
    $this->title = 'История изменения депозитов';
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="deposits-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $arColumns,
    ]); ?>
</div>
