<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Name')); ?>
        
            <?= $form->field($model, 'description')->textInput()->label(Yii::t('backend', 'Description')); ?>
        
            <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Rule Name')); ?>
        
            </div>        
        </div>    
        
        <div class="box box-warning">
        <div class="box-body">
            <?php $roles= ArrayHelper::map($roles,'name','name'); ?>
            <?= $form->field($model, '_roles')->checkboxList($roles,[
                'class'=> 'checkbox',
                'separator' => '<br/>',
            ])->label(Yii::t('backend', 'Roles')); ?>

        </div>
        </div>  
                
        <div class="form-group" style="padding: 5px 0">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>          
    </div>

    
    <div class="col-md-6">
        <div class="box box-warning">
        <div class="box-body">
            <?php $permissions = ArrayHelper::map($permissions,'name','name'); ?>
            <?= $form->field($model, '_permissions')->checkboxList($permissions,[
                'class'=> 'checkbox',
                'separator' => '<br/>',
            ])->label(Yii::t('backend', 'Permissions')); ?>
        </div>
        </div>
    </div>    
    <?php ActiveForm::end(); ?>
</div>