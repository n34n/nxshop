<?php 
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use backend\models\City;
?>


<?php 
$dataProvider = new ActiveDataProvider(['query' => City::find()->where("pid='".$key."'")]);
?>


<?=   GridView::widget([
    		'layout' => '{items}',
        'dataProvider' =>  $dataProvider,
        'columns' => [
	            'city_id',
	            'city_name',
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
        			'detailRowCssClass'=> GridView::TYPE_DANGER,
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
	        		'headerOptions'=>['class'=>'kartik-sheet-style'],
	        		'expandOneOnly'=>true,
        		],
        ],
        // pjax is set to always true for this demo
        'pjax'=>false,
        // set export properties
        'export'=>false,
        'showHeader'=>false,
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
