<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use backend\models\ProductComment;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Comment');
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
			
			<?= $form->field($model, 'product_id')->dropDownList(ProductComment::getProduct(),['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('menu', 'Product')) ?>
			
			<?= $form->field($model, 'comment')->textInput()->label(Yii::t('menu', 'Comment')) ?>
			
			<?php
			      if($model->file == ''){
			          echo $form->field($model, 'file[]')->label(Yii::t('backend', 'Image'))->widget(FileInput::classname(), [
			                    'name' => 'file',
			                    'options' => [
			                    		'multiple' => true,
			                    		'accept' => 'image/*'
			                    		],
			                    'pluginOptions' => [
			                        'showPreview' => true,
			                        'showCaption' => true,
			                        'showRemove' => false,
			                        'showUpload' => false,
		                    		// 最少上传的文件个数限制
		                    		'minFileCount' => 0,
		                    		// 最多上传的文件个数限制
		                    		'maxFileCount' => 5,
			                    ]
			          ]);
			      }else{
			          echo $form->field($model, 'file[]')->label(Yii::t('backend', 'Image'))->widget(FileInput::classname(), [
			              'name' => 'file',
			              'options' => [
			              			'multiple' => true,
			              			'accept' => 'image/*'
			              			],
			              'pluginOptions' => [
			                  'showRemove' => false,
			                  'showUpload' => false,
			              		// 最少上传的文件个数限制
			              	   'minFileCount' => 1,
			              		// 最多上传的文件个数限制
			              	   'maxFileCount' => 10,
			              	   // 预览的文件
			                  'initialPreview'=> $model->file,
			                  'initialPreviewAsData'=>true,
			                  'initialCaption'=>"",
			              	  // 需要展示的图片设置，比如图片的宽度等
			              	 'initialPreviewConfig' => $initialPreviewConfig,
// 			                  'initialPreviewConfig' => [
// 			                      [
// 			                          'showZoom' => false,
// 			                          //'width'=>'30px',
// 			                          //'height'=>'auto',
// 			                          'url'=> 'index.php?r=product-brand/deleteimg&id='.$model->img_id,
// 			                          //'key'=>'100',
			                          
// 			                      ],
// 			                  ], 
			                  'overwriteInitial'=>true,	
			              ]
			          ]);          
			      }
    		?> 
			
			<?= $form->field($model, 'csi')->dropDownList(['1' => Yii::t('backend', 'Dissatisfied'), '3' => Yii::t('backend', 'Commonly'), '5' => Yii::t('backend', 'Satisfied')])->label(Yii::t('backend', 'Csi')) ?>

			<?= $form->field($model, 'created_by')->textInput(['value'=>Yii::$app->user->identity->username,'readonly'=>'true'])->label(Yii::t('backend', 'Created by')) ?>
			
			<?= $form->field($model, 'checked_by')->textInput(['value'=>Yii::$app->user->identity->username,'readonly'=>'true'])->label(Yii::t('backend', 'Checked by')) ?>
			
            <?= $form->field($model, 'display')->dropDownList(['Y' => Yii::t('backend', 'Show'), 'N' => Yii::t('backend', 'Disabled'), ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Disabled')) ?>
            </div>
        </div>
        <div class="form-group" style="padding: 5px 15px">
           <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>         
    </div>
    <?php ActiveForm::end(); ?>
</div>
