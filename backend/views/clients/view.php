<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Clients */

$this->title = "Клиент: {$model->getFullName()}";
$this->params['breadcrumbs'][] = ['label' => 'Клинты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'personal_number',
            [
                'attribute' => 'fullName',
                'label' => 'ФИО'
            ],
            'user.username',
            'user.email',
            [
                'attribute' => 'birthday',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->birthday, 'php:d-m-Y');
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
                'attribute' => 'updated_at',
                'value' => function ($row) {
                    return  Yii::$app->formatter->asDate($row->updated_at, 'php:d-m-Y');
                }
            ],
        ],
    ]) ?>

</div>
