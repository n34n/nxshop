<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_type') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'stage') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'consignee') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'telphone') ?>

    <?php // echo $form->field($model, 'idcard') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'buyer') ?>

    <?php // echo $form->field($model, 'buyer_mobile') ?>

    <?php // echo $form->field($model, 'buyer_idcard') ?>

    <?php // echo $form->field($model, 'invoice') ?>

    <?php // echo $form->field($model, 'invoice_title') ?>

    <?php // echo $form->field($model, 'order_weight') ?>

    <?php // echo $form->field($model, 'order_quantity') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'product_amount') ?>

    <?php // echo $form->field($model, 'shipping_fee') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'save') ?>

    <?php // echo $form->field($model, 'order_amount') ?>

    <?php // echo $form->field($model, 'order_sn') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'pay_method') ?>

    <?php // echo $form->field($model, 'pay_sn') ?>

    <?php // echo $form->field($model, 'pay_at') ?>

    <?php // echo $form->field($model, 'express_com') ?>

    <?php // echo $form->field($model, 'express_sn') ?>

    <?php // echo $form->field($model, 'express_at') ?>

    <?php // echo $form->field($model, 'confirm_at') ?>

    <?php // echo $form->field($model, 'express_csi') ?>

    <?php // echo $form->field($model, 'service_csi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
