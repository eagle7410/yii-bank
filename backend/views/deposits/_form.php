<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $data backend\manages\deposits\DepositCreateUpdateData */
/* @var $form yii\widgets\ActiveForm */

$optionNumber = [
    'type' => 'number',
    'min' => '0'
];

$model = $data->getModelDeposits();

$optionClientBox = [ 'prompt' => 'Выберете клиента ...'];

if (!$model->isNewRecord) {
    $optionClientBox['disabled'] = true;
}

?>

<div class="deposits-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'client_id')->dropDownList($data->getClientList(), $optionClientBox) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'sum')->textInput($optionNumber) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'seePercent')->textInput() ?>
        </div>

        <?php if(empty($model->status) || $model->status === \common\models\Deposits::STATUS_CREATE): ?>
            <div class="col-md-3">
                <?= $form->field($model, 'start_at')->widget(
                    DateControl::classname(), [
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);?>
            </div>
        <?php endif; ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Открыть' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
