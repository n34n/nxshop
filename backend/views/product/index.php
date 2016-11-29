<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Product');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <?php 
              echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm']);
        ?>
       <div class="box-tools">
            <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                            'id' => 'search-form',
                            'options' => ['class' => 'form-horizontal'],
                        ]); ?>
                            <div class='input-group input-group-sm' style='width: 300px;margin-top:5px;'>
                            <?= $form->field($searchModel, 'skey',[
                                  'options'=>['class'=>'input-group input-group-sm','style'=>'width: 300px;'],
                                  'inputOptions' => ['placeholder' => Yii::t('backend', 'Search Keyword'),'class' => 'form-control pull-right'],
                                    ])->label(false); ?>
                             <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                                </button>
                             </div>
                             </div>

            <?php ActiveForm::end(); ?>
        </div>         
    </div>



<?= GridView::widget([
    'layout' => '<div class="bg-light-blue disabled color-palette alert" style="margin-bottom:0">{summary}</div>
                 <div class="box-body">{items}</div>
                 <div class="box-footer clearfix pull-right">{pager}</div>',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        //'summary' => '显示{begin}-{end},一共{count}条记录',
        'summary'=> Yii::t('backend', 'Showing {begin}-{end} of {totalCount} items.'),
        'options' => [
            'class' => 'box-body',
        ],
        'tableOptions' => ['class' => 'table table-hover'],
 
        'columns' => [
//         		['class' => 'yii\grid\SerialColumn'],//关联字段排序
        		'id' => [
        				'attribute' => 'product_id',
        				'label' => Yii::t('backend', 'Id'),
        		],
//         		[
//         			'label' => Yii::t('menu', 'Category'),
//         			'value' => function ($modle){
// 		        		$name = '';
// 		        		foreach ($modle->categories as $categories){
// 		        			$name .= $categories->name;
// 		        		}
// 		        		return $name;
// 		        	}
//         		],
//         		[
// 	        		'label' => Yii::t('menu', 'Tag'),
// 	        		'value' => function ($modle){
// 		        		$name = '';
// 		        		foreach ($modle->tags as $Tags){
// 		        			$name .= $Tags->name;
// 		        		}
// 		        		return $name;
// 	        		}
//         		],
        		'title' => [
                    'attribute' => 'title',
                    'label' => Yii::t('backend', 'Title'),
                    //'enableSorting' => false,
                ],
            
                'subtitle' => [
                    'attribute' => 'subtitle',
                    'label' => Yii::t('backend', 'Subtitle'),
                    //'enableSorting' => false,
                ],
                
                'sku' => [
                    'attribute' => 'sku',
                    'label' => Yii::t('backend', 'Sku'),
                    //'enableSorting' => false,
                ],            
                
                 'barcode' => [
                     'attribute' => 'barcode',
                     'label' => Yii::t('backend', 'Barcode'),
                     //'enableSorting' => false,
                 ],
                
                 'origin_id' => [
                     'attribute' => 'origin_id',
                     'label' => Yii::t('menu', 'Origin'),
                     //'enableSorting' => false,
                 ],
        		'is_multi_spec' => [
        				'attribute' => 'is_multi_spec',
        				'label' => Yii::t('backend', 'Is_multi_spec'),
        				'format' => 'html',
        				'value'=> function($model){
        					return  $model->online=='Y'?'<span class="label label-success">'.Yii::t('backend', 'Yes').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'No').'</span>';
        				},
        				//'enableSorting' => false,
        		],
        		'is_cross_border' => [
        				'attribute' => 'is_cross_border',
        				'label' => Yii::t('backend', 'Is_cross_border'),
        				'format' => 'html',
        				'value'=> function($model){
        				return  $model->online=='Y'?'<span class="label label-success">'.Yii::t('backend', 'Yes').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'No').'</span>';
        				},
        				//'enableSorting' => false,
        				],
        		'sender_id' => [
        				'attribute' => 'sender_id',
        				'label' => Yii::t('menu', 'Sender'),
        				//'enableSorting' => false,
        		],
//         		'details' => [
//         				'attribute' => 'details',
//         				'label' => Yii::t('backend', 'Details'),
//         				//'enableSorting' => false,
//         		],
        		'online' => [
        				'attribute' => 'online',
        				'label' => Yii::t('backend', 'Online'),
        				'format' => 'html',
        				'value'=> function($model){
        					return  $model->online=='Y'?'<span class="label label-success">'.Yii::t('backend', 'Yes').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'No').'</span>';
        				},
        				//'enableSorting' => false,
        		],
        		'online_scheduled' => [
        				'attribute' => 'online_scheduled',
        				'label' => Yii::t('backend', 'Online_time'),
        				//'enableSorting' => false,
        		],
        		'created_by' => [
        				'attribute' => 'created_by',
        				'label' => Yii::t('backend', 'Created by'),
        				//'enableSorting' => false,
        		],
        		[
        		'attribute' => 'created_at',
        		'label' => Yii::t('backend', 'Created at'),
        		'format' => ['date', 'php:Y-m-d h:i:s'],
//         		'enableSorting' => false,
        		],
        		'updated_by' => [
        				'attribute' => 'updated_by',
        				'label' => Yii::t('backend', 'Updated by'),
        				//'enableSorting' => false,
        		],
        		[
        		'attribute' => 'updated_at',
        		'label' => Yii::t('backend', 'Updated at'),
        		'format' => ['date', 'php:Y-m-d h:i:s'],
//         		'enableSorting' => false,
        		],
                [
                    'class' => 'yii\grid\ActionColumn',
                  	'template' => '{update} {delete}',
                        'buttons' => [
//                             'changepwd' => function ($url, $model, $key) {
//                                 return  Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, ['title' => Yii::t('backend', 'Change Password')] ) ;
//                             },
                         ],                    
                ],
        ],
    ]); ?>


</div>
