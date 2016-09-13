<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'User').' '.Yii::t('backend', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box">
    <div class="box-header with-border">
        <a class="btn btn-sm"></a>
        <div class="box-tools">
            <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                            'id' => 'search-form',
                            'options' => ['class' => 'form-horizontal'],
                        ]); ?>
                            <div class='input-group input-group-sm' style='width: 300px;margin-top:5px;'>
                            <?= $form->field($searchModel, 'skey',[
                                  'options'=>['class'=>'input-group input-group-sm','style'=>'width: 300px;'],
                                  'inputOptions' => ['placeholder' => Yii::t('backend', 'Search Keyword'),'class' => 'form-control pull-right'],
                                    ])->label(false); ?>
                             <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                                </button>
                             </div>
                             </div>

            <?php ActiveForm::end(); ?>
        </div>    
    </div>    
    
<?php Pjax::begin(); ?> 

<?= GridView::widget([
    'layout' => '<div class="bg-light-blue disabled color-palette alert" style="margin-bottom:0">{summary}</div>
                 <div class="box-body">{items}</div>
                 <div class="box-footer clearfix pull-right">{pager}</div>',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        
    'summary'=> Yii::t('backend', 'Showing {begin}-{end} of {totalCount} items.'),
    
        'options' => [
            'class' => 'box-body',
        ],
    
        'tableOptions' => ['class' => 'table table-hover'],
 
        'columns' => [
                'id' => [
                    'attribute' => 'id',
                    'enableSorting' => false,
                ],
                
                'username' => [
                    'attribute' => 'username',
                    'label' => Yii::t('backend', 'Username'),
                    'enableSorting' => false,
                ],
                
                 'action' => [
                     'attribute' => 'action',
                     'label' => Yii::t('backend', 'Action'),
                     'enableSorting' => false,
                 ],
                
                 'ip' => [
                     'attribute' => 'ip',
                     'label' => Yii::t('backend', 'IP'),
                     'enableSorting' => false,
                 ],
                
                 'agent' => [
                    'attribute' => 'agent',
                     'label' => Yii::t('backend', 'Agent'),
                     'enableSorting' => false,
                ],
                
                [
                    'attribute' => 'log_time',
                    'label' => Yii::t('backend', 'Date'),
                    'format' => ['date', 'php:Y-m-d h:i:s'],
                    'enableSorting' => false,
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                     'template' => '{view}',                  
                ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
