<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

//use mdm\admin\components\AccessControl;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Comment');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box">
    <div class="box-header with-border">

        
        <?php 
			 echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm']);
        ?>
            
    </div>    
    
<?php Pjax::begin(); ?> 

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
            'id' => [
                    'attribute' => 'comment_id',
            		'label' => Yii::t('backend', 'Id'),
//                     'enableSorting' => false,
                ],
        		
        		'product_id' => [
        				'attribute' => 'product_id',
        				'label' => Yii::t('menu', 'Product'),
        				//'enableSorting' => false,
        		],
                
                'reply_id' => [
                    'attribute' => 'reply_id',
                    'label' => Yii::t('backend', 'Reply id'),
                    //'enableSorting' => false,
                ],
            
                'member_id' => [
                    'attribute' => 'member_id',
                    'label' => Yii::t('backend', 'Username'),
                	'value'=> function (){
                		return Yii::$app->user->identity->username;
                	} 
                    //'enableSorting' => false,
                ],
        		
                'comment' => [
                    'attribute' => 'comment',
                    'label' => Yii::t('menu', 'Comment'),
                    //'enableSorting' => false,
                ],
        		'csi' => [
        				'attribute' => 'csi',
        				'label' => Yii::t('backend', 'Csi'),
        				'value'=> function ($model){
		        				$state = [
		        						'1' => Yii::t('backend', 'Dissatisfied'),
		        						'3' => Yii::t('backend', 'Commonly'),
		        						'5' => Yii::t('backend', 'Satisfied'),
		        				];
		        				return $state[$model->csi];
        				}
        				//'enableSorting' => false,
        		],
        		'created_by' => [
        				'attribute' => 'created_by',
        				'label' => Yii::t('backend', 'Created by'),
        				'value'=> function (){
        				 	return Yii::$app->user->identity->username;
        				}
        				//'enableSorting' => false,
        		],
                 'created_at' => [
                     'attribute' => 'created_at',
                     'label' => Yii::t('backend', 'Created at'),
                 	 'format' => ['date', 'php:Y-m-d h:i:s'],
                     //'enableSorting' => false,
                 ],
        		'checked_by' => [
        				'attribute' => 'checked_by',
        				'label' => Yii::t('backend', 'Checked by'),
        				'value'=> function (){
        					return Yii::$app->user->identity->username;
        				}
        				//'enableSorting' => false,
        		],
        		'checked_at' => [
        				'attribute' => 'checked_at',
        				'label' => Yii::t('backend', 'Checked at'),
        				'format' => ['date', 'php:Y-m-d h:i:s'],
        				//'enableSorting' => false,
        		],
        		
        		'display'=> [
        				'attribute' => 'display',
        				'label' => Yii::t('backend', 'Disabled'),
        				'format' => 'html',
        				'value'=> function($model){
        					return  $model->display=='Y'?'<span class="label label-success">'.Yii::t('backend', 'Approved').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'Denied').'</span>';
        				},
        				//'enableSorting' => false,
        		],
        		[
        		'class' => 'yii\grid\ActionColumn',
        		'template' => '{update}{delete}',//只需要展示删除和更新
        		'buttons' => [],
        		],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
