<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'subtitle') ?>

    <?= $form->field($model, 'sku') ?>

    <?= $form->field($model, 'barcode') ?>

    <?php // echo $form->field($model, 'brand_id') ?>

    <?php // echo $form->field($model, 'origin_id') ?>

    <?php // echo $form->field($model, 'is_multi_spec') ?>

    <?php // echo $form->field($model, 'specification') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'is_cross_border') ?>

    <?php // echo $form->field($model, 'sender_id') ?>

    <?php // echo $form->field($model, 'tax_rate') ?>

    <?php // echo $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'online') ?>

    <?php // echo $form->field($model, 'online_scheduled') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
