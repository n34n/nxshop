<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use backend\models\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use mdm\admin\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */

AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
		'id' => ProductCategory::getpid(),
]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('menu', 'Category');
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

            <?= $form->field($model, 'name')->textInput()->label(Yii::t('backend', 'Name')); ?>
  
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


    	<div class="form-group field-productcategory-pid">
			<label class="col-sm-2 control-label" for="productcategory-pid">父级</label><div class="col-sm-10" style="padding-right:30px">
			<select id="productcategory-pid" class="form-control " name="ProductCategory[pid]">
				<option value='0'><?php echo Yii::t('backend', 'Please Select ...'); ?></option>
				<?php 
					$ProductCategory = new ProductCategory();
					$ProductCategory->dropDownList($model->pid);
				?>
			</select></div><div style="margin:8px 0 0 100px"><div class="help-block"></div></div>
		</div>
		
            <?= $form->field($model, 'order')->textInput()->label(Yii::t('backend', 'Order')); ?>
            
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
            <table class="table table-striped">
            <tbody>
            <?php
            	$ProductCategory = new ProductCategory();
            	$ProductCategory->setCategoryList();
            ?>
            </tbody>
            </table>
        </div>

        </div>
    </div>
    </div>    
</div>
