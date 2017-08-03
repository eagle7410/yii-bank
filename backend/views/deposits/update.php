<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data backend\manages\deposits\DepositCreateUpdateData */

$model = $data->getModelDeposits();
$this->title = 'Изменить депозит №: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Депозиты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Депозит #' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменения';
?>
<div class="deposits-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [ 'data' => $data  ]) ?>

</div>
