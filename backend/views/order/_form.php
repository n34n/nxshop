<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
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
        
	    <?= $form->field($model, 'member_id')->dropDownList(ArrayHelper::map(User::find()->select('id,username')->all(), 'id', 'username'),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false,'data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}")]) ?>

	    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Consignee')) ?>
	
		<?= $form->field($model, 'order_type')->dropDownList([ 'abroad' => 'Abroad', 'bonded' => 'Bonded', 'general' => 'General', ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Order Type')) ?>
	
	    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Mobile')) ?>
	
	    <?= $form->field($model, 'telphone')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Telphone')) ?>
	
	    <?= $form->field($model, 'idcard')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Idcard')) ?>
	
	    <?= $form->field($model, 'province')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Province')) ?>
	
	    <?= $form->field($model, 'city')->textInput(['maxlength' => true])->label(Yii::t('backend', 'City')) ?>
	
	    <?= $form->field($model, 'area')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Area')) ?>
	
	    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Address')) ?>
	
	    <?= $form->field($model, 'buyer')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Buyer')) ?>
	
	    <?= $form->field($model, 'buyer_mobile')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Buyer Mobile')) ?>
	
	    <?= $form->field($model, 'buyer_idcard')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Buyer Idcard')) ?>
	
	    <?= $form->field($model, 'invoice')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Invoice')) ?>
	
	    <?= $form->field($model, 'invoice_title')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Invoice Title')) ?>
	
	    <?= $form->field($model, 'order_weight')->textInput()->label(Yii::t('backend', 'Order Weight')) ?>
	
	    <?= $form->field($model, 'order_quantity')->textInput()->label(Yii::t('backend', 'Order Quantity')) ?>
	
	    <?= $form->field($model, 'currency')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Currency')) ?>
	
	    <?= $form->field($model, 'product_amount')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Product Amount')) ?>
	
	    <?= $form->field($model, 'shipping_fee')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Shipping Fee')) ?>
	
	    <?= $form->field($model, 'tax')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Tax')) ?>
	
	    <?= $form->field($model, 'save')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Save')) ?>
	
	    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Order Amount')) ?>
	
	    <?= $form->field($model, 'order_sn')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Order Sn')) ?>
	
	    <?= $form->field($model, 'created_at')->textInput()->label(Yii::t('backend', 'Created at')) ?>
	
	    <?= $form->field($model, 'pay_method')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Pay Method')) ?>
	
	    <?= $form->field($model, 'pay_sn')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Pay Sn')) ?>
	
	    <?= $form->field($model, 'pay_at')->textInput()->label(Yii::t('backend', 'Pay At')) ?>
	
	    <?= $form->field($model, 'express_com')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Express Com')) ?>
	
	    <?= $form->field($model, 'express_sn')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Express Sn')) ?>
	
	    <?= $form->field($model, 'express_at')->textInput()->label(Yii::t('backend', 'Express At')) ?>
	
	    <?= $form->field($model, 'confirm_at')->textInput()->label(Yii::t('backend', 'Confirm At')) ?>
	
	    <?= $form->field($model, 'express_csi')->textInput()->label(Yii::t('backend', 'Express Csi')) ?>
	
	    <?= $form->field($model, 'service_csi')->textInput()->label(Yii::t('backend', 'Service Csi')) ?>

        </div>
        </div>
    </div>
    
        <div class="form-group" style="padding: 8px 0 0 145px">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
    <?php ActiveForm::end(); ?>
</div>
