<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data backend\manages\deposits\DepositCreateUpdateData */

$this->title = 'Открыть депозит';
$this->params['breadcrumbs'][] = ['label' => 'Депозиты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposits-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [ 'data' => $data  ]) ?>
    
</div>
