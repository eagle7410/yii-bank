<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DepositOperations */

$this->title = 'Добавить операцию';
$this->params['breadcrumbs'][] = ['label' => 'Операции над депозитами', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-operations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
