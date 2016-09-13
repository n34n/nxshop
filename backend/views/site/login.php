<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('backend', 'Sign in');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
            <img src="images/logo-db.png" title="NXshop Backend Management" alt="NXshop Backend Management" />
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => Yii::t('backend', 'Username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => Yii::t('backend', 'Password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('backend', 'Remember Me')) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('backend', 'Sign in'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
