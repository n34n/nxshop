<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">

    <?php $form = ActiveForm::begin(
        [
        'options'     => ['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 145px">{error}</div>',
            'labelOptions'  => ['class' => 'col-sm-2 control-label'],
        ],
        ]        
        ); ?>
    <div class="box-body">
    <?= $form->field($model, 'language')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Language')); ?>
    
    <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Code')); ?>

    <?php //$form->field($model, 'icon')->fileInput() ?>
    
    <?php
      if($model->icon == ''){
          echo $form->field($model, 'icon')->label(Yii::t('backend', 'Icon'))->widget(FileInput::classname(), [
                    'name' => 'icon',
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
          echo $form->field($model, 'icon')->label(Yii::t('backend', 'Icon'))->widget(FileInput::classname(), [
              'name' => 'icon',
              'options' => ['accept' => 'image/*'],
              'pluginOptions' => [
                  //'uploadUrl' => 'index.php?r=language/uploadimg',
                  //'deleteUrl' => 'index.php?r=language/deleteimg',
                  'showRemove' => false,
                  'showUpload' => false,
                  
                  'initialPreview'=>[
                      "$src",
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

    <div class="form-group" style="padding: 8px 0 0 145px">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
