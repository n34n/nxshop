<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Brand');
$this->params['breadcrumbs'][] = $this->title;
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
                          'url'=> 'index.php?r=product-brand/deleteimg&id='.$model->img_id,
                          //'key'=>'100',
                          
                      ],
                  ], 
                  'overwriteInitial'=>true,
              ]
          ]);          
      }
    ?> 

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
        'dataProvider' => $dataProvider,
    	'layout' => '<div class="box-body">{items}</div>',
        'columns' => [
            'brand_id'=> [
				'attribute' => 'brand_id',
				'label' => Yii::t('backend', 'Id'),
				//'enableSorting' => false,
				],
            'name'=> [
				'attribute' => 'name',
				'label' => Yii::t('backend', 'Name'),
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
				//'enableSorting' => false,
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
