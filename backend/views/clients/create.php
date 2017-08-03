<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $data \backend\manages\clients\ClientShowData */

$this->title = 'Добавить клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клинты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'data' => $data,
    ]) ?>

</div>
