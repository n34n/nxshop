<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="row">

    <?php $form = ActiveForm::begin(
        [
        'options'     => ['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 145px">{error}</div>',
            'labelOptions'  => ['class' => 'col-sm-2 control-label'],
        ],
        ]        
        ); ?>
        
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
	
	<?= $form->field($model, 'language')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Language')); ?>
    
    <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Code')); ?>

    <?php //$form->field($model, 'icon')->fileInput() ?>
    
    <?php
      if($model->file == ''){
          echo $form->field($model, 'file')->label(Yii::t('backend', 'Icon'))->widget(FileInput::classname(), [
                    'name' => 'file',
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        //'uploadUrl' => 'index.php?r=language/uploadimg',
                        //'showZoom' => false,
                        //'uploadUrl' => Url::to(['/rbac/uploads/images/flag']),
/*                         'uploadExtraData' => [
                            'album_id' => 20,
                            'cat_id' => 'Nature'
                        ],   */  
/*                         'initialPreviewConfig '=> [
                            ['size' => '873727', 'showZoom' => false],
                        ], */
                    ]
          ]);
      }else{
          //echo Html::img($src, array('width'=>'50px'));
          echo $form->field($model, 'file')->label(Yii::t('backend', 'Icon'))->widget(FileInput::classname(), [
              'name' => 'file',
              'options' => ['accept' => 'image/*'],
              'pluginOptions' => [
                  //'uploadUrl' => 'index.php?r=language/uploadimg',
                  //'deleteUrl' => 'index.php?r=language/deleteimg',
                  'showRemove' => false,
                  'showUpload' => false,
                  
                  'initialPreview'=>[
                      "$model->file",
                  ],
                  'initialPreviewAsData'=>true,
                  'initialCaption'=>"",
                  'initialPreviewConfig' => [
                      [
                          //'caption'=> 'desert.jpg',
                          'showZoom' => false,
                          //'width'=>'30px',
                          //'height'=>'auto',
                          'url'=> 'index.php?r=language/deleteimg&id='.$model->id,
                          //'key'=>'100',
                          
                      ],
                  ], 
                  'overwriteInitial'=>true,
              ]
          ]);          
      }
    ?>
    
    <?= $form->field($model, 'order')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Order')) ?>
    
    <?= $form->field($model, 'status')->dropDownList(['10' => Yii::t('backend', 'Approved'), '0' => Yii::t('backend', 'Denied')])->label(Yii::t('backend', 'Status')); ?>
				
				
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
	        //'filterModel' => $searchModel,
	        'columns' => [
	            //['class' => 'yii\grid\SerialColumn'],
	
	            //'id',
	            'path_s' => [
	                'attribute' => 'path_s',
	                'format' => 'html',
	                'label' => Yii::t('backend', 'Icon'),
 	                'value'  => function($model){
	                    return Html::img(FILE_PATH.$model->path_s);
	                }, 
	                'enableSorting' => false,
	             ],
	            
	            'code' => [
	                'attribute' => 'code',
	                'label' => Yii::t('backend', 'Code'),
	                'enableSorting' => false,
	            ],
	            
	            'language' => [
	                'attribute' => 'language',
	                'label' => Yii::t('backend', 'Language'),
	                'enableSorting' => false,
	            ],
	            
	             'status' => [
	                'attribute' => 'status',
	                 'label' => Yii::t('backend', 'Status'),
	                 'format' => 'html',
	                'value'=> function($model){
	                    return  $model->status==10?'<span class="label label-success">'.Yii::t('backend', 'Approved').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'Denied').'</span>';
	                },
	                'enableSorting' => false,
	            ],
	            
	            'order' => [
	                'attribute' => 'order',
	                'label' => Yii::t('backend', 'Order'),
	                'enableSorting' => false,
	            ],          
	
	           [
	                'class' => 'yii\grid\ActionColumn',
	                        //'template' => $template,
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






