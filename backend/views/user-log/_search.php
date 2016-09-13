<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\UserLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'action') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'agent') ?>

    <?php // echo $form->field($model, 'get') ?>

    <?php // echo $form->field($model, 'post') ?>

    <?php // echo $form->field($model, 'log_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
