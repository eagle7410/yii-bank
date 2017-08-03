<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DepositOperationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Операции над депозитами';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-operations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить операцию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'alias',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
