<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
// use kartik\select2\Select2;
use backend\models\City;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = Yii::t('backend', 'Create').' '.Yii::t('menu', 'Orders');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("div.form-group select").addClass("selectpicker");$("div.form-group select").attr({"data-style" : "form-control","data-style-Base" : ""});',\yii\web\View::POS_END);
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

	    <?= $form->field($model, 'order_type')->dropDownList([ 'abroad' => 'Abroad', 'bonded' => 'Bonded', 'general' => 'General', ], ['prompt' => Yii::t('backend', 'Please Select ...')]) ?>
	   
	    <?= $form->field($model, 'buyer')->dropDownList(ArrayHelper::map(User::find()->select('id,username')->all(), 'id', 'username'),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false,'data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}")])?>
	
	    <?= $form->field($model, 'buyer_mobile')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'buyer_idcard')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Consignee')) ?>
	
	    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'telphone')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'idcard')->textInput(['maxlength' => true]) ?>


	    <?= $form->field($model, 'province')->dropDownList(ArrayHelper::map(City::find()->where('level=:level')->addParams([':level' => '1'])->asArray()->all(), 'city_id', 'city_name'),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false,'data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}")])  ?>
	    
	    <?php
	    echo $form->field($model, 'city')->widget(DepDrop::classname(), [
	    		'options' => ['placeholder' => Yii::t('backend', 'Please Select ...')],
	    		'type' => DepDrop::TYPE_SELECT2,
	    		'select2Options'=>['pluginOptions'=>['allowClear'=>true],'theme'=>'default','hideSearch'=>true],
	    		'pluginOptions'=>[
	    				'depends'=>['order-province'],
	    				'url' => Url::to(['/city/child-city']),
	    				'loadingText' => 'Loading child level 1 ...',
	    		]
	    ]);
	    
	    echo $form->field($model, 'area')->widget(DepDrop::classname(), [
	    		'options' => ['placeholder' => 'Select ...'],
	    		'type' => DepDrop::TYPE_SELECT2,
	    		'select2Options'=>['pluginOptions'=>['allowClear'=>true],'theme'=>'default','hideSearch'=>true],
	    		'pluginOptions'=>[
	    				'depends'=>['order-city'],
	    				'url' => Url::to(['/city/child-city']),
	    				'loadingText' => 'Loading child level 1 ...',
	    		]
	    ]);
	    
	    
	    ?>

		<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'invoice')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Invoice')) ?>
	
	    <?= $form->field($model, 'invoice_title')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'order_weight')->textInput() ?>
	
	    <?= $form->field($model, 'order_quantity')->textInput() ?>
	
	    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'product_amount')->textInput(['maxlength' => true])?>
	
	    <?= $form->field($model, 'shipping_fee')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'save')->textInput(['maxlength' => true]) ?>
	
	    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'created_at')->textInput() ?>
	
	    <?= $form->field($model, 'pay_method')->textInput(['maxlength' => true])?>

        </div>
        </div>
        
        <div class="form-group" style="padding: 5px 15px">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        
    </div>
    
           <div class="col-md-6">
    	<div class="box box-warning">
        <div class="box-body">
        
			<div class= "grid_is_hide">
			<?= GridView::widget([
		    	'layout' => '<div class="box-body">{items}</div>',
		        'dataProvider' => $dataProvider,
// 				'tableOptions' => ['style'=>'width:200px;'],
// 					'containerOptions'=>['style'=>'width:200px;'],
		        'columns' => [
	        		[
	        		'class' => 'yii\grid\CheckboxColumn',
// 	        		'name' => 'multiple_spec_id',
	        		],
		        	'id'=> [
						'attribute' => 'id',
							//'enableSorting' => false,
						],
		            'order_sn'=> [
							'attribute' => 'order_sn',
							//'enableSorting' => false,
						],
		        	'product_id'=> [
		        			'attribute' => 'product_id',
		        			//'enableSorting' => false,
		        		],
		        	'spec_id'=> [
		        			'attribute' => 'spec_id',
		        			//'enableSorting' => false,
		        		],
		            'sku'=> [
							'attribute' => 'sku',
							//'enableSorting' => false,
						],
		        	'product_name'=> [
			        		'attribute' => 'product_name',
			        		//'enableSorting' => false,
		        		],
		        	'tax_rate'=> [
		        			'attribute' => 'tax_rate',
		        			//'enableSorting' => false,
		        		],
		        	'unit_price'=> [
			        		'attribute' => 'unit_price',
			        		//'enableSorting' => false,
		        		],
		        	'unit_weight'=> [
			        		'attribute' => 'unit_weight',
			        		//'enableSorting' => false,
		        		],
		        	'quantity'=> [
		        			'attribute' => 'quantity',
		        			//'enableSorting' => false,
		        		],
	        		'subtotal_price'=> [
	        				'attribute' => 'subtotal_price',
	        				//'enableSorting' => false,
	        		],
	        		'subtotal_weight'=> [
	        				'attribute' => 'subtotal_weight',
	        				//'enableSorting' => false,
	        		],
		        		
		        		
// 		        	[
// 						'class' => 'backend\components\Action',
// 						'template' => '{product-specification/index:update} {product-specification/delete:delete}',
// 		        		'buttons' => [
// 								'update'=> function ($url, $Model, $key) {
// 									return Html::a('', '', ['id' => 'update','data-toggle' => 'modal','data-target' => '#create-modal','data-pjax' => '0','class' => 'glyphicon glyphicon-pencil','onclick'=>'update_status('.$key.');']);
// 								},
// 								'product-specification'=> function ($url, $Model, $key) {
// 									$options = array_merge([
// 											'title' => Yii::t('yii', 'Delete'),
// 											'aria-label' => Yii::t('yii', 'Delete'),
// 											'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
// 											'data-method' => 'post',
// 											'data-pjax' => '0',
// 									]);
// 									return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
// 								},
// 						],
// 					],
		        ],
				// pjax is set to always true for this demo
				'pjax'=>false,
				// set export properties
				'export'=>false,
		    ]); ?>
		    
		    <?php 
		    echo Html::a(Yii::t('backend', 'Create'), '#', ['id' => 'create','data-toggle' => 'modal','data-pjax' => '0','data-target' => '#create-modal','class' => 'btn btn-success','onclick'=>'create_spec();']);
		    
		    //echo Html::a('批量添加', '#', ['id' => 'batch_create','data-toggle' => 'modal','data-pjax' => '0','data-target' => '#batch-create-modal','class' => 'btn btn-success']);
		    	
		    //echo Html::a('批量删除', "#",['id'=>'delete_Spec','class' => 'btn btn-success gridview','onclick'=>'delete_Spec_batch();']);
		    ?>
		    </div> 
    	</div>
    	</div>
    </div>
    
    

    <?php ActiveForm::end(); ?>
</div>


