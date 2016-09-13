<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
//$listData=ArrayHelper::map('正常','禁用');
?>

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(Yii::t('backend', 'New Password')); ?>
    
    <div class="form-group" style="padding-top: 15px">
        <?= Html::submitButton('<i class="fa fa-lock"> </i> '.Yii::t('backend', 'Change Password').'', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
        </div>
    </div>
</div>
