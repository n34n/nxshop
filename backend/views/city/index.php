<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\City;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'City');
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="box">

    <div class="box-header ">
        <?php 
              echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm']);
        ?>
       <div class="box-tools">
			
			
			
			
			
        </div>   
    </div>
    
    <?=   GridView::widget([
    		'layout' => '<div class="box-body">
    						<div class="bg-light-blue disabled color-palette alert" style="margin-bottom:0">
    							{summary}
    						</div>
    						{items}
    					</div>
    					<div class="box-footer">{pager}</div>',
        'dataProvider' => $dataProvider,
//     	'filterModel' => $searchModel,
    	'summary'=> Yii::t('backend', 'Showing {begin}-{end} of {totalCount} items.'),
        'columns' => [
	            'city_id',
	            'city_name',
//         		[
// 	        		'attribute'=>'city_name',
// 	        		'vAlign'=>'middle',
// 	        		'width'=>'180px',
// 	        		'value'=>function ($model, $key, $index, $widget) {
// 	        		return Html::a($model->city_id,
// 	        				'#',
// 	        				['title'=>'View author detail', 'onclick'=>'alert("This will open the author page.\n\nDisabled for this demo!")']);
// 	        		},
// 	        		'filterType'=>GridView::FILTER_SELECT2,
// 	        		'filter'=>ArrayHelper::map(City::find()->orderBy('city_id')->asArray()->all(), 'city_id', 'city_name'),
// 	        		'filterWidgetOptions'=>[
// 	        				'pluginOptions'=>['allowClear'=>true],
// 	        		],
// 	        		'filterInputOptions'=>['placeholder'=>'Any author'],
// 	        		'format'=>'raw'
//         		],
        		
        		'pid',
	            'post_code',
	            'code',
	            'level',
	            'order',
        		'disabled'=> [
	        				'attribute' => 'disabled',
	        				'label' => Yii::t('backend', 'Status'),
	        				'format' => 'html',
	        				'value'=> function($model){
	        					return  $model->disabled=='Y'?'<span class="label label-success">'.Yii::t('backend', 'Yes').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'No').'</span>';
	        				},
        				],
        		
        		[
		            'class' => 'yii\grid\ActionColumn',
        			'template' => '{update} {delete}',
	            ],
        		[
	        		'class'=>'kartik\grid\ExpandRowColumn',
        			'header'=>false,
					'allowBatchToggle'=>false,
        			'hiddenFromExport'=>false,
        			'detailRowCssClass'=> GridView::TYPE_SUCCESS,
        			'expandTitle'=>Yii::t('backend', 'Expand'),
        			'collapseTitle'=>Yii::t('backend', 'Collapse'),
        			'expandIcon'=>'<a><span class="glyphicon glyphicon-chevron-down"></span></a>',
        			'collapseIcon'=>'<a style="color:#f39c12;"><span class="glyphicon glyphicon-chevron-up"></span></a>',
	        		'value'=>function ($model, $key, $index, $column) {
	        			return GridView::ROW_COLLAPSED;
	        		},
// 	        		'detailUrl'=>'index.php?r=city/expand',
	        		'detail'=>function ($model, $key, $index, $column) {
	        			return  Yii::$app->controller->renderPartial('_expand', ['key'=>$key]);
	        		},
	        		'expandOneOnly'=>true,
        		],
        ],
        // pjax is set to always true for this demo
        'pjax'=>false,
        // set export properties
        'export'=>false,
//         'headerRowOptions'=>false,
        // parameters from the demo form
//         'bordered' => true,
//         'striped' => false,
//         'condensed' => false,
//         'responsive' => true,
//         'hover' => true,
//         'floatHeader' => true,
//         'showPageSummary' => true,
//         'panel' => [
//         		'type' => GridView::TYPE_PRIMARY
//         ],
    ]); ?>


</div>
