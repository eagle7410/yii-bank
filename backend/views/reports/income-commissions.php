<?php
/* @var $this yii\web\View */
/* @var $data [] */
?>
<h1>Начислений и комиссий</h1>

<table class="table">
    <thead>
        <tr>
            <th>Месяць</th>
            <th>Начисления</th>
            <th>Комиссия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $year => $stats):?>
            <tr class="info"><td colspan="3" align="center"><b>За <?= $year ?> год</b></td></tr>

            <?php foreach ($stats as $month => $statistics):?>
                <tr >
                    <td><?= $month ?> месяць</td>
                    <td><?= \Yii::$app->formatter->asCurrency($statistics['addPercent']) ?></td>
                    <td><?= \Yii::$app->formatter->asCurrency($statistics['minusCommissions']) ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endforeach; ?>
    </tbody>
</table>
