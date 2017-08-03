<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DepositOperations */

$this->title = 'Редактировать операцию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Операции над депозитами', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Операция : {$model->name}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="deposit-operations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
