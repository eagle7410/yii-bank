<?php

/* @var $this yii\web\View */
/* @var $data frontend\manages\deposits\DepositIndexData */

$this->title = 'Персональные данные';
?>
<div class="site-index">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['data' => $data]) ?>
</div>
