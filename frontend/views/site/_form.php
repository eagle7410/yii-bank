<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $data frontend\manages\clients\ClientShowData */
/* @var $form yii\widgets\ActiveForm */

$modelUser = $data->getModelUser();

?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?php if($modelUser->client): ?>
            <div class="col-lg-6">

                <?= $form->field($modelUser->client, 'personal_number')->textInput([
                    'type' => 'number',
                    'disabled' => true,
                ]) ?>
                <?= $form->field($modelUser->client, 'name')->textInput([
                    'maxlength' => true,
                    'disabled' => true,
                ]) ?>

                <?= $form->field($modelUser->client, 'surname')->textInput([
                    'maxlength' => true,
                ]) ?>

                <?= $form->field($modelUser->client, 'middle_name')->textInput([
                    'maxlength' => true,
                    'disabled' => true,
                ]) ?>
            </div>
        <?php endif; ?>
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
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
