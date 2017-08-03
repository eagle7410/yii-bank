<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data \backend\manages\clients\ClientShowData */

$client = $data->getModelClient();
$clientFullName = $client->getFullName();
$this->title = "Редактирование клиента: $clientFullName";

$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Клиент: $clientFullName", 'url' => ['view', 'id' => $client->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'data' => $data,
    ]) ?>

</div>
