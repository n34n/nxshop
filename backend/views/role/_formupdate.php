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
            <?= $form->field($model, '_name')->hiddenInput(['value'=>$model->name]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Name')); ?>
 
            <?= $form->field($model, 'group')->dropDownList(Yii::$app->params['roleGroup'], ['prompt'=>'Please Select ...'])->label(Yii::t('backend', 'Group')); ?>
        
            <?= $form->field($model, 'description')->textInput()->label(Yii::t('backend', 'Description')); ?>
        
            <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Rule Name')); ?>
        
            </div>        
        </div>    
        
        <div class="box box-warning">
        <div class="box-body">
        	<p>
            <label class="control-label"><?= Yii::t('backend', 'Roles') ?></label>
            </p>
            
            <?php $roleschecked= ArrayHelper::map($roleschecked,'child','child'); ?>
            
            <?php 
            	foreach ($roles as $key=>$_role){
            		echo '<h5 style="background-color:#e2e2e2;padding:4px">'.$key.'</h5>';
            		
            		foreach ($_role as $__role){
            			$role[$__role] = $__role;
            		}
            		
            		echo Html::checkboxList('roles',$roleschecked,$role,[
            				'class'=> 'checkbox',
							'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
							'item' => function($index, $label, $name, $checked, $value) {
										$checked=$checked?"checked":"";
										$return = '<label><input type="checkbox" value="'.$label.'" name="_roles[]" '.$checked.'>'.$label.'</label>';
										return $return;
									  }
							]);
					unset($role);
            	}
            ?>

        </div>
        </div>  
                
        <div class="form-group" style="padding: 5px 0">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>          
    </div>

    
    <div class="col-md-6">
        <div class="box box-warning">
        <div class="box-body">
            <label class="control-label"><?= Yii::t('backend', 'Permissions') ?></label>
            <?php $permissions= ArrayHelper::map($permissions,'name','name'); ?>
            <?php $permissionschecked= ArrayHelper::map($permissionschecked,'child','child'); ?>
            <?= Html::checkboxList('Role[_permissions]',$permissionschecked,$permissions,[
                'class'=> 'checkbox',
                'separator' => '<br/>',
            ]) ?>
        </div>
        </div>
    </div>    
    <?php ActiveForm::end(); ?>
</div>