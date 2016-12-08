<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\CitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'city_name') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'post_code') ?>

    <?= $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'disabled') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
