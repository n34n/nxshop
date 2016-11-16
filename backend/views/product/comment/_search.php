<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ProductCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'comment_id') ?>

    <?= $form->field($model, 'reply_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'hidden_name') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'checked_at') ?>

    <?php // echo $form->field($model, 'checked_by') ?>

    <?php // echo $form->field($model, 'display') ?>

    <?php // echo $form->field($model, 'csi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
