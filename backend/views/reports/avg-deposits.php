<?php
/* @var $this yii\web\View */
/* @var $data [] */
?>
<h1>Средняя сумма депозита</h1>

<table class="table">
    <thead>
        <tr>
            <th>Група</th>
            <th>Средняя сумма</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Група I (От 18 до 25 лет)</td>
            <td><?= \Yii::$app->formatter->asCurrency($data['group1']) ?></td>
        </tr>
        <tr>
            <td>Група II (От 25 до 50 лет)</td>
            <td><?= \Yii::$app->formatter->asCurrency($data['group2']) ?></td>
        </tr>
        <tr>
            <td>Група II (От 50 лет)</td>
            <td><?= \Yii::$app->formatter->asCurrency($data['group3']) ?></td>
        </tr>
    </tbody>
</table>
