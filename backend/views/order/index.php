<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <?php 
              echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm']);
        ?>
       <div class="box-tools">
			
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
        		'id' => [
        				'attribute' => 'order_id',
        		],
        		'order_type' => [
                    'attribute' => 'order_type',
                    //'enableSorting' => false,
                ],
            
                'order_status' => [
                    'attribute' => 'status',
                    //'enableSorting' => false,
                ],
                
                'consignee' => [
                    'attribute' => 'consignee',
                    //'enableSorting' => false,
                ],            
                
                 'idcard' => [
                     'attribute' => 'idcard',
                     //'enableSorting' => false,
                 ],
                
                 'province' => [
                     'attribute' => 'province',
                     //'enableSorting' => false,
                 ],
        		'city' => [
        				'attribute' => 'city',
        		],
        		'area' => [
        				'attribute' => 'area',
        				],
        		'address' => [
        				'attribute' => 'address',
        		],
        		'buyer' => [
        				'attribute' => 'buyer',
        				//'enableSorting' => false,
        		],
        		'buyer_mobile' => [
        				'attribute' => 'buyer_mobile',
        		],
        		'buyer_idcard' => [
        				'attribute' => 'buyer_idcard',
        				//'enableSorting' => false,
        		],
        		'invoice' => [
        				'attribute' => 'invoice',
        				//'enableSorting' => false,
        		],
        		'invoice_title' => [
        				'attribute' => 'invoice_title',
        				//'enableSorting' => false,
        		],
        		'order_weight' => [
        				'attribute' => 'order_weight',
        				//'enableSorting' => false,
        		],
        		'order_quantity' => [
        				'attribute' => 'order_quantity',
        				//'enableSorting' => false,
        		],
        		'currency' => [
        				'attribute' => 'currency',
        				//'enableSorting' => false,
        		],
        		'product_amount' => [
        				'attribute' => 'product_amount',
        				//'enableSorting' => false,
        		],
        		'shipping_fee' => [
        				'attribute' => 'shipping_fee',
        				//'enableSorting' => false,
        		],
        		'tax' => [
        				'attribute' => 'tax',
        				//'enableSorting' => false,
        		],
        		'save' => [
        				'attribute' => 'save',
        				//'enableSorting' => false,
        		],
        		'order_amount' => [
        				'attribute' => 'order_amount',
        				//'enableSorting' => false,
        		],
        		'order_sn' => [
        				'attribute' => 'order_sn',
        				//'enableSorting' => false,
        		],
        		'pay_method' => [
        				'attribute' => 'pay_method',
        				//'enableSorting' => false,
        		],
        		'pay_sn' => [
        				'attribute' => 'pay_sn',
        				//'enableSorting' => false,
        		],
        		'pay_at' => [
        				'attribute' => 'pay_at',
        				//'enableSorting' => false,
        		],
        		'express_com' => [
        				'attribute' => 'express_com',
        				//'enableSorting' => false,
        		],
        		'express_sn' => [
        				'attribute' => 'express_sn',
        				//'enableSorting' => false,
        		],
        		'express_at' => [
        				'attribute' => 'express_at',
        				//'enableSorting' => false,
        		],
        		'confirm_at' => [
        				'attribute' => 'confirm_at',
        				//'enableSorting' => false,
        		],
        		'express_csi' => [
        				'attribute' => 'express_csi',
        				//'enableSorting' => false,
        		],
        		'service_csi' => [
        				'attribute' => 'service_csi',
        				//'enableSorting' => false,
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
