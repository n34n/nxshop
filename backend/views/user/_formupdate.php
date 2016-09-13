<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
//$listData=ArrayHelper::map('正常','禁用');
?>

<div class="row">
    <?php $form = ActiveForm::begin(
            [
                'options'     => ['class'=>'form-horizontal'],
                'fieldConfig' => [
                    'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 145px">{error}</div>',
                    'labelOptions'  => ['class' => 'col-sm-2 control-label'],
                 ],
            ]
        ); ?>
    <div class="col-md-6">
        <div class="box box-primary">
        <div class="box-body">
        <?php  
            if($model->isNewRecord)
            {
                echo $form->field($model, 'username')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Username'));
            }else{
                echo $form->field($model, 'username',['inputOptions' => ['class'=>'form-control','disabled'=>'']])->textInput(['maxlength' => true])->label(Yii::t('backend', 'Username'));
            }
        ?>
        
        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Firstname')); ?>
        
        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Lastname')); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Email')); ?>

        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Mobile')); ?>
        
        <?php if($model->isNewRecord)
              {
                  echo $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(Yii::t('backend', 'Password'));;
              }
        ?>
    
    <?php
    if(Yii::$app->controller->action->id != 'update-profile'){
      echo $form->field($model, 'status')->dropDownList(['10' => Yii::t('backend', 'Approved'), '0' => Yii::t('backend', 'Denied')])->label(Yii::t('backend', 'Status')); 
    }
    ?>
    
        <div class="form-group" style="padding: 8px 0 0 145px">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-warning">
        <div class="box-body">
            <div class="form-group field-user-_roles">
                <label class="col-sm-2 control-label"><?= Yii::t('backend', 'Roles') ?></label>
                <div class="col-sm-10">
                <?php $roles= ArrayHelper::map($roles,'name','name'); ?>
                <?php $roleschecked= ArrayHelper::map($roleschecked,'name','name'); ?>
                <?= Html::checkboxList('User[_roles]',$roleschecked,$roles,[
                    'class'=> 'checkbox',
                    'separator' => '<br/>',
                ]) ?>
            </div>
            </div>
        </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
