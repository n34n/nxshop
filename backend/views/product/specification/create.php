<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Specification');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php $form = ActiveForm::begin(
        [
        'options'     => ['class'=>'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template'      => '{label}<div class="col-sm-10" style="padding-right:30px">{input}</div><div style="margin:8px 0 0 100px">{error}</div>',
            'labelOptions'  => ['class' => 'col-sm-2 control-label'],
        ],
        ]        
        ); ?>
    
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
				<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Name')); ?>
				
				<?= $form->field($model, 'type')->dropDownList([ 'size' => Yii::t('backend', 'Size'), 'color' => Yii::t('backend', 'Color')],['prompt' => Yii::t('backend', 'Please Select ...')])->label(Yii::t('backend', 'Type')); ?>
				
				<?= $form->field($model, 'order')->textInput()->label(Yii::t('backend', 'Order')) ?>

            </div>
        </div>
        <div class="form-group" style="padding: 5px 15px">
           <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
