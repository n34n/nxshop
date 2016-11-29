<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\ProductCategory;
use backend\models\Product;
use yii\base\Widget;
use yii\bootstrap\Modal;
use backend\components\Action;
use yii\helpers\Url;
use yii\base\Model;
use kartik\file\FileInput;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

// use backend\models\ProductSpecification;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Product');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs($this->render('_script.js'));//尾部执行
$this->registerJs($this->render('_function.js'),\yii\web\View::POS_HEAD);//头部执行

?>
<div class="row">


<?php $form = ActiveForm::begin(
        [
        'options'     => ['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 100px">{error}</div>',
            'labelOptions'  => ['class' => 'col-sm-2 control-label'],
        	'inputOptions' => ['class' => 'form-control pull-right'],
        ],
        ]        
        ); ?>
 
    <div class="col-md-6" >
    
        <div class="box box-primary">
            <div class="box-body">

				<?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Title')); ?>

				<?= $form->field($model, 'subtitle')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Subtitle')); ?>

		    	<?php
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
    			?>

				<?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(ProductCategory::getCategoryAll(0, ProductCategory::find ()->orderBy ( 'level' )->asArray()->all ()), 'category_id', 'label'),['multiple'=>true,'data-actions-box'=>'true','data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}"),'data-none-Selected-Text'=>Yii::t('backend', 'Please Select ...'),'data-select-all-text'=>Yii::t('backend', 'Select All'),'data-deselect-all-text'=>Yii::t('backend', 'Deselect All')])->label(Yii::t('menu', 'Category')); ?>

				<?= $form->field($model, 'tag_id')->dropDownList(Product::getTagAll(),['multiple'=>true,'data-actions-box'=>'true','data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}"),'data-none-Selected-Text'=>Yii::t('backend', 'Please Select ...'),'data-select-all-text'=>Yii::t('backend', 'Select All'),'data-deselect-all-text'=>Yii::t('backend', 'Deselect All')])->label(Yii::t('menu', 'Tag'));?>

				<?= $form->field($model, 'brand_id')->dropDownList(Product::getBrandAll(),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false,'data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}")])->label(Yii::t('menu', 'Brand'));?>

            	<?= $form->field($model, 'origin_id')->dropDownList(Product::getOriginAll(),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false,'data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}")])->label(Yii::t('menu', 'Origin')) ?>

            	<?= $form->field($model, 'is_multi_spec')->dropDownList([ 'Y' => Yii::t('backend', 'Yes'), 'N' => Yii::t('backend', 'No')],['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Is_multi_spec')) ?>
            	
				<?= $form->field($model, 'is_cross_border')->dropDownList([  'Y' => Yii::t('backend', 'Yes'), 'N' => Yii::t('backend', 'No')],['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Is_cross_border')) ?>
            	
            	<?= $form->field($model, 'sender_id')->dropDownList(Product::getSenderAll(),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false])->label(Yii::t('menu', 'Sender')) ?>

            	<?= $form->field($model, 'details')->widget(yii\redactor\widgets\Redactor::className(),['clientOptions' => ['lang' => 'zh_cn','plugins' => ['clips', 'fontcolor','imagemanager']]])->label(Yii::t('backend', 'Details')) ?>
            	
            	<?= $form->field($model, 'skey',['inputOptions'=>['placeholder' => Yii::t('backend', 'Please "|" as the separator')]])->textInput(['maxlength' => true])->label(Yii::t('backend', 'Keyword')) ?>
            	
            	<?= $form->field($model, 'online')->dropDownList(['Y' => Yii::t('backend', 'Yes'), 'N' => Yii::t('backend', 'No')],['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Online')) ?>
            	
            	<?= $form->field($model, 'online_scheduled')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Online_scheduled')) ?>
            	
            	<?= $form->field($model, 'created_by')->textInput(['value'=>Yii::$app->user->identity->username,'readonly'=>'true'])->label(Yii::t('backend', 'Created by')) ?>

            	<?= $form->field($model, 'updated_by')->textInput(['value'=>Yii::$app->user->identity->username,'readonly'=>'true'])->label(Yii::t('backend', 'Updated by')) ?>
	
            </div>
        </div>
        <div class="form-group" style="padding: 5px 15px">
           <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
         
    </div>
    

        <div class="is_hide col-md-6">
    	<div class="box box-warning">
        <div class="box-body">
				
			<div class = "form_is_hide">
				<?= $form->field($model, 'specification')->dropDownList( [ Yii::t('backend', 'Color') => Product::getSpecificationAll('color'), Yii::t('backend', 'Size') => Product::getSpecificationAll('size')],['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false])->label(Yii::t('menu', 'Specification')) ?>
            
            	<?= $form->field($model, 'price')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Price')); ?>
            	
            	<?= $form->field($model, 'weight')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Weight')); ?>
            	
            	<?= $form->field($model, 'stock')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Stock')); ?>

				<?= $form->field($model, 'sku')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Sku')); ?>
				
				<?= $form->field($model, 'barcode')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Barcode')); ?>
				
				<?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Tax_rate')) ?>
			</div>
			<div class= "grid_is_hide">
			<?= GridView::widget([
		    	'layout' => '<div class="box-body">{items}</div>
			                 <div class="clearfix pull-right">{pager}</div>',
		        'dataProvider' => $specDataProvider,
				
				'options' => ['id' => 'batch_id'],
		        'columns' => [
	        		[
	        		'class' => 'yii\grid\CheckboxColumn',
	        		'name' => 'multiple_spec_id',
	        		],
		        	'spec_id'=> [
						'attribute' => 'spec_id',
						'label' => Yii::t('backend', 'Id'),
						//'enableSorting' => false,
						],
		            'name'=> [
						'attribute' => 'name',
						'label' => Yii::t('backend', 'Name'),
						//'enableSorting' => false,
						],
		            'sku'=> [
						'attribute' => 'sku',
						'label' => Yii::t('backend', 'Sku'),
						//'enableSorting' => false,
						],
		            'barcode'=> [
						'attribute' => 'barcode',
						'label' => Yii::t('backend', 'Barcode'),
						//'enableSorting' => false,
						],
		        		'price'=> [
		        				'attribute' => 'price',
		        				'label' => Yii::t('backend', 'Price'),
		        				//'enableSorting' => false,
		        		],
		        		'weight'=> [
		        				'attribute' => 'weight',
		        				'label' => Yii::t('backend', 'Weight'),
		        				//'enableSorting' => false,
		        		],
		        		'stock'=> [
		        				'attribute' => 'stock',
		        				'label' => Yii::t('backend', 'Stock'),
		        				//'enableSorting' => false,
		        		],
		        		'tax_rate'=> [
		        				'attribute' => 'tax_rate',
		        				'label' => Yii::t('backend', 'Tax_rate'),
		        				//'enableSorting' => false,
		        		],
		        		'order'=> [
		        				'attribute' => 'order',
		        				'label' => Yii::t('backend', 'Order'),
		        				//'enableSorting' => false,
		        		],	
		        	[
						'class' => 'backend\components\Action',
						'template' => '{product-specification/index:update} {product-specification/delete:delete}',
		        		'buttons' => [
								'update'=> function ($url, $Model, $key) {
									return Html::a('', '', ['id' => 'update','data-toggle' => 'modal','data-target' => '#create-modal','data-pjax' => '0','class' => 'glyphicon glyphicon-pencil','onclick'=>'update_status('.$key.');']);
								},
								'product-specification'=> function ($url, $Model, $key) {
									$options = array_merge([
											'title' => Yii::t('yii', 'Delete'),
											'aria-label' => Yii::t('yii', 'Delete'),
											'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
											'data-method' => 'post',
											'data-pjax' => '0',
									]);
									return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
								},
						],
					],
		        ],
		    ]); ?>
		    
		    <?php 
		    echo Html::a(Yii::t('backend', 'Create'), '#', ['id' => 'create','data-toggle' => 'modal','data-pjax' => '0','data-target' => '#create-modal','class' => 'btn btn-success','onclick'=>'create_spec();']);
		    
		    echo Html::a('批量添加', '#', ['id' => 'batch_create','data-toggle' => 'modal','data-pjax' => '0','data-target' => '#batch-create-modal','class' => 'btn btn-success']);
		    	
		    echo Html::a('批量删除', "#",['id'=>'delete_Spec','class' => 'btn btn-success gridview','onclick'=>'delete_Spec_batch();']);
		    ?>
		    </div> 
    	</div>
    	</div>
    </div>
    <?php ActiveForm::end(); ?>

</div>



<!-- 创建规格弹出框  begin -->
		<?php 
		Modal::begin([
				'id' => 'create-modal',
				'header' => '<h4 class="modal-title">创建规格</h4>',
		]);
		$form = ActiveForm::begin(
		[
		'options'     => ['id'=>'popup','class'=>'form-horizontal','enctype' => 'multipart/form-data'],
		'enableAjaxValidation'=>true,
		'validationUrl' => Url::toRoute(['validate-form']),
		'fieldConfig' => [
				'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 100px">{error}</div>',
				'labelOptions'  => ['class' => 'col-sm-2 control-label'],
				'inputOptions' => ['class' => 'form-control pull-right'],
		],
		'action' => '/nxshop/backend/web/index.php?r=product-specification/create',
		]
		);
		
		Pjax::begin();

		?>
		
		<?= $form->field($specModel, 'spec_id')->textInput(['maxlength' => true])->label(Yii::t('backend', 'id')); ?>
		
		<?= $form->field($specModel, 'name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Name')); ?>
		
		<?= $form->field($specModel, 'size')->dropDownList(Product::getSpecificationAll('size'),['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Size')); ?>

		<?= $form->field($specModel, 'color')->dropDownList(Product::getSpecificationAll('color'),['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Color')); ?>

		<?= $form->field($specModel, 'price')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Price')); ?>
            	
        <?= $form->field($specModel, 'weight')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Weight')); ?>
            	
        <?= $form->field($specModel, 'stock')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Stock')); ?>

		<?= $form->field($specModel, 'sku')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Sku')); ?>
		
		<?= $form->field($specModel, 'tax_rate')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Tax_rate')) ?>
		
		<?= $form->field($specModel, 'order')->textInput()->label(Yii::t('backend', 'Order')) ?>

		<div class="form-group" style="padding: 5px 15px">
		<?= Html::submitButton(Yii::t('backend', 'Create'), ['class' => 'btn btn-primary','id' => 'btn_spec']) ?>
		<a href="#" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('backend', 'Cancel')?></a>
 		</div>
 		<?php Pjax::end(); ?>
		<?php ActiveForm::end();  ?>
		<div id='request' style='display:none'>请求中,请稍等</div>
		<?php  Modal::end(); ?>
<!-- 创建规格弹出框  end -->

<!-- 批量创建规格弹出框  begin -->
		<?php
		
		Modal::begin([
				'id' => 'batch-create-modal',
				'header' => '<h4 class="modal-title">批量创建规格</h4>',
		]);
		$form = ActiveForm::begin(
				[
				'options'     => ['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
				'fieldConfig' => [
						'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 100px">{error}</div>',
						'labelOptions'  => ['class' => 'col-sm-2 control-label'],
						'inputOptions' => ['class' => 'form-control pull-right'],
				],
				'action' => '/nxshop/backend/web/index.php?r=product-specification/batch-create',
				]
		);
		?>

		<?= $form->field($specModel, 'size')->dropDownList(Product::getSpecificationAll('size'),['multiple'=>true,'data-actions-box'=>'true','data-none-Selected-Text'=>Yii::t('backend', 'Please Select ...'),'data-select-all-text'=>Yii::t('backend', 'Select All'),'data-deselect-all-text'=>Yii::t('backend', 'Deselect All')])->label(Yii::t('backend', 'Size')); ?>

		<?= $form->field($specModel, 'color')->dropDownList(Product::getSpecificationAll('color'),['multiple'=>true,'data-actions-box'=>'true','data-none-Selected-Text'=>Yii::t('backend', 'Please Select ...'),'data-select-all-text'=>Yii::t('backend', 'Select All'),'data-deselect-all-text'=>Yii::t('backend', 'Deselect All')])->label(Yii::t('backend', 'Color')); ?>

		<div class="form-group" style="padding: 5px 15px">
		<?= Html::submitButton(Yii::t('backend', 'Create'), ['class' => 'btn btn-primary','id' => 'btn_spec_batch']) ?>
		<a href="#" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('backend', 'Cancel')?></a>
 		</div>
		<?php ActiveForm::end(); Modal::end(); ?>
<!-- 批量创建规格弹出框  end -->	