<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'order_type',
            'member_id',
            'stage',
            'status',
            'consignee',
            'mobile',
            'telphone',
            'idcard',
            'province',
            'city',
            'area',
            'address',
            'buyer',
            'buyer_mobile',
            'buyer_idcard',
            'invoice',
            'invoice_title',
            'order_weight',
            'order_quantity',
            'currency',
            'product_amount',
            'shipping_fee',
            'tax',
            'save',
            'order_amount',
            'order_sn',
            'created_at',
            'pay_method',
            'pay_sn',
            'pay_at',
            'express_com',
            'express_sn',
            'express_at',
            'confirm_at',
            'express_csi',
            'service_csi',
        ],
    ]) ?>

</div>
