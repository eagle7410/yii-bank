<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Это <?= Yii::$app->params['brandLabel'] ?></h3>

    <h3>Разработал Щербина Игорь Анатольевич</h3>
    <p>E-mail: verycooleagle@gmail.com<br/>Skype: EagleEagle7410</p>
</div>
