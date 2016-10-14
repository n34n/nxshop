<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Tag');
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
				<?= $form->field($model, 'type')->textInput(['value'=>'product'])->label(Yii::t('backend', 'Type')); ?>
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
    	'layout' => '<div class="box-body">{items}</div>
	                 <div class="box-footer clearfix pull-right">{pager}</div>',
        'columns' => [		
        	'tag_id'=> [
				'attribute' => 'tag_id',
				'label' => Yii::t('backend', 'Id'),
				//'enableSorting' => false,
				],
            'name'=> [
				'attribute' => 'name',
				'label' => Yii::t('backend', 'Name'),
				//'enableSorting' => false,
				],
            'type'=> [
				'attribute' => 'type',
				'label' => Yii::t('backend', 'Type'),
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
