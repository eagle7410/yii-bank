<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Deposits;

/* @var $this yii\web\View */
/* @var $model common\models\Deposits */

$this->title = 'Депозит #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Депозиты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposits-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($model->status === Deposits::STATUS_CREATE): ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            ]
        ],
    ]) ?>

</div>
