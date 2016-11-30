<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Sender');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("div.form-group select").addClass("selectpicker");$("div.form-group select").attr({"data-style" : "form-control","data-style-Base" : ""});',\yii\web\View::POS_END);
?>
<div class="row">
<?php $form = ActiveForm::begin(
        [
        'options'     => ['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 100px">{error}</div>',
            'labelOptions'  => ['class' => 'col-sm-2 control-label'],
        ],
        ]        
        ); ?>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
			
			<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Name')); ?>

			<?= $form->field($model, 'type')->dropDownList([ 'general' => Yii::t('backend', 'General'), 'abroad' => Yii::t('backend', 'Abroad'), 'bonded' => Yii::t('backend', 'Bonded') ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Type')) ?>
			
			<?php
			      if($model->file == ''){
			          echo $form->field($model, 'file')->label(Yii::t('backend', 'Image'))->widget(FileInput::classname(), [
			                    'name' => 'file',
			                    'options' => ['accept' => 'image/*'],
			                    'pluginOptions' => [
			                        'showPreview' => true,
			                        'showCaption' => true,
			                        'showRemove' => false,
			                        'showUpload' => false,
			                    ]
			          ]);
			      }else{
			          echo $form->field($model, 'file')->label(Yii::t('backend', 'Image'))->widget(FileInput::classname(), [
			              'name' => 'file',
			              'options' => ['accept' => 'image/*'],
			              'pluginOptions' => [
			                  'showRemove' => false,
			                  'showUpload' => false,
			                  
			                  'initialPreview'=>[
			                      "$model->file",
			                  ],
			                  'initialPreviewAsData'=>true,
			                  'initialCaption'=>"",
			                  'initialPreviewConfig' => [
			                      [
			                          'showZoom' => false,
			                          //'width'=>'30px',
			                          //'height'=>'auto',
			                          'url'=> 'index.php?r=sender/deleteimg&id='.$model->img_id,
			                          //'key'=>'100',
			                          
			                      ],
			                  ], 
			                  'overwriteInitial'=>true,
			              ]
			          ]);          
			      }
    		?> 			

			<?= $form->field($model, 'code')->textInput()->label(Yii::t('backend', 'Code')) ?>
			
			<?= $form->field($model, 'order')->textInput()->label(Yii::t('backend', 'Order')) ?>

            <?= $form->field($model, 'disabled')->dropDownList([ 'Y' => Yii::t('backend', 'Show'), 'N' => Yii::t('backend', 'Disabled'), ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Disabled')) ?>
			
            </div>
        </div>
        <div class="form-group" style="padding: 5px 15px">
           <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>         
    </div>
    <?php ActiveForm::end(); ?>
    
    
    <div class="col-md-6">
    	<div class="box box-warning">
        <div class="box-body">

    <?= GridView::widget([
    		'layout' => '<div class="box-body">{items}</div>
	                 <div class="box-footer clearfix pull-right">{pager}</div>',
        'dataProvider' => $dataProvider,
        'columns' => [
        		
//         	'path_s' => [
//         		'attribute' => 'path_s',
//         		'format' => 'html',
//         		'label' => Yii::t('backend', 'Icon'),
//         		'value'  => function($model){
//         		return Html::img(FILE_PATH.$model->path_s);
//         		},
//         		'enableSorting' => false,
//         		], 
        				
        	'sender_id'=> [
				'attribute' => 'sender_id',
				'label' => Yii::t('backend', 'Id'),
				//'enableSorting' => false,
				],
            'type'=> [
				'attribute' => 'type',
				'label' => Yii::t('backend', 'Type'),
				//'enableSorting' => false,
				],
        	
            'name'=> [
				'attribute' => 'name',
				'label' => Yii::t('backend', 'Name'),
				//'enableSorting' => false,
				],
        		
        	'code'=> [
        		'attribute' => 'code',
        		'label' => Yii::t('backend', 'Code'),
        		//'enableSorting' => false,
        		],
        	'order'=> [
        		'attribute' => 'order',
        		'label' => Yii::t('backend', 'Order'),
        		//'enableSorting' => false,
        		],
            'disabled'=> [
				'attribute' => 'disabled',
				'label' => Yii::t('backend', 'Status'),
            	'format' => 'html',
            	'value'=> function($model){
            		return  $model->disabled=='Y'?'<span class="label label-success">'.Yii::t('backend', 'Yes').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'No').'</span>';
            	},
				//'enableSorting' => false,
				],
			[
				'class' => 'yii\grid\ActionColumn',
						'buttons' => [
						'view' => function ($url, $model, $key) {
							return;
						},
				],
			],

        ],
    ]); ?>
    	</div>
    	</div>
    </div>
</div>
