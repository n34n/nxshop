<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\City;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\City */

$this->title = $model->isNewRecord?Yii::t('backend', 'Create').' '.Yii::t('backend', 'City'):Yii::t('backend', 'Update').' '.Yii::t('backend', 'City');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("div.form-group select").addClass("selectpicker");$("div.form-group select").attr({"data-style" : "form-control","data-style-Base" : ""});',\yii\web\View::POS_END);
?>

<div class="row">
    <?php $form = ActiveForm::begin(
            [
                'options'     => ['class'=>'form-horizontal'],
                'fieldConfig' => [
                    'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 145px">{error}</div>',
                    'labelOptions'  => ['class' => 'col-sm-2 control-label'],
                 ],
            ]
        ); ?>
    <div class="col-md-5">
        <div class="box box-primary">
        <div class="box-body">

        <?= $form->field($model, 'city_name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'City Name')); ?>
        
        <?= $form->field($model, 'pid')->dropDownList(ArrayHelper::map(City::getCityAll(0, City::find ()->where('level != 3')->orderBy ( 'city_id' )->asArray()->all ()), 'city_id', 'label'),['prompt' => Yii::t('backend', 'Please Select ...'),'multiple'=>false,'data-live-search'=>'true','data-live-search-placeholder'=>Yii::t('backend', 'Search'),'data-none-Results-Text'=>Yii::t('backend', "No results matched {0}")])->label(Yii::t('backend', 'Parent')); ?>

        <?= $form->field($model, 'post_code')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Post Code')); ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Area Code')); ?>
        
        <?= $form->field($model, 'order')->textInput()->label(Yii::t('backend', 'Order')) ?>
         
        <?= $form->field($model, 'disabled')->dropDownList([ 'Y' => Yii::t('backend', 'Show'), 'N' => Yii::t('backend', 'Disabled'), ], ['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Disabled')) ?>
        
        </div>
        </div>

        <div class="form-group" style="padding: 5px 15px">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
