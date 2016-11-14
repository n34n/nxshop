<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductOriginSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Specification');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=row>
    <div class="box-header with-border" style="padding:15px;">
        <?php 
             echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm']);
        ?>   
    </div> 
	
 	<div class="col-xs-6">
    	<div class="box">
 			<?= GridView::widget([
             		'layout' => '<div class ="box-header">
 									<h3 class="box-title">'.Yii::t('backend', 'Size').'</h3>
 								</div>
 								<div class="box-body">{items}</div>',
 					'tableOptions' => [
 										'class' => 'table table-hover',
 									],
 					'dataProvider' => $dataProviderSize, 
             		'columns' => [
             				'id'=> [
             						'attribute' => 'id',
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
  
  <div class="col-xs-6">
    	<div class="box">
 			<?= GridView::widget([
             		'layout' => '<div class ="box-header">
 									<h3 class="box-title">'.Yii::t('backend', 'Color').'</h3>
 								</div>
 								<div class="box-body">{items}</div>',
 					'tableOptions' => [
 										'class' => 'table table-hover',
 									],
 					'dataProvider' => $dataProviderColor, 
             		'columns' => [
             				'id'=> [
             						'attribute' => 'id',
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
