<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $data backend\manages\clients\ClientCreateUpdateData */
/* @var $form yii\widgets\ActiveForm */

$modelClient = $data->getModelClient();
$modelUser = $data->getModelUser();

?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">

            <?= $form->field($modelClient, 'personal_number')->textInput([
                'type' => 'number'
            ]) ?>
            <?= $form->field($modelClient, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelClient, 'middle_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelClient, 'surname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelClient, 'birthday')->widget(
                DateControl::classname(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'value' => '2017-08-09',
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]); ?>

            <?= $form->field($modelClient, 'is_man')->checkbox() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($modelUser, 'username')->textInput([
                'autofocus' => false,
                'reqiure' => true
            ]) ?>

            <?= $form->field($modelUser, 'email')->textInput([
                'type' => 'email'
            ]) ?>

            <?= $form->field($modelUser, 'newPassword')->textInput([
                'autofocus' => false
            ]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($modelClient->isNewRecord ? 'Добавить' : 'Обновить',
            ['class' => $modelClient->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
