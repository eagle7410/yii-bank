<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $data \backend\manages\clients\ClientIndexData */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
$now = new \DateTime();
$birthday = new \DateTime();
$userList = $data->getUserList();
?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data->getDataProvider(),
        'filterModel' => $data->getModelClient(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user.status',
                'content' => function ($row) {
                    $class = $row->user->status === User::STATUS_ACTIVE ? 'glyphicon-ok success-color' : 'glyphicon-remove fail-color';
                    return "<span class='glyphicon $class '>{$row->user->statusLabel}</span>";
                },
            ],
            'user.username',
            'personal_number',
            'name',
            'middle_name',
            'surname',
            [
                'attribute' => 'birthday',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->birthday, 'php:d-m-Y');
                }
            ],
            [
                'label' => 'Возраст',
                'value' => function ($row) use ($now, $birthday) {
                    $birthday->setTimestamp($row->birthday);
                    $diff = $birthday->diff($now);

                    return $diff->y;
                }
            ],
            [
                'attribute' => 'is_man',
                'value' => function ($row) {
                    return  $row->is_man ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->created_at, 'php:d-m-Y');
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($row) use ($userList) {
                    return  isset($userList[$row->created_by]) ? $userList[$row->created_by] : $row->created_by;
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->updated_at, 'php:d-m-Y');
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($row) use ($userList) {
                    return  isset($userList[$row->updated_by]) ? $userList[$row->updated_by] : $row->updated_by;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
