<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

//use mdm\admin\components\AccessControl;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'User');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box">
    <div class="box-header with-border">

        
        <?php 
            if(Yii::$app->user->can('用户编辑') || Yii::$app->user->can('用户管理') || Yii::$app->user->can('admin')){
                echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm']);
            }else{
                echo '<a class="btn btn-sm"></a>';
            }
        ?>
        
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
        //'summary' => '显示{begin}-{end},一共{count}条记录',
        
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
                    //'enableSorting' => false,
                ],
            
                'firstname' => [
                    'attribute' => 'firstname',
                    'label' => Yii::t('backend', 'Firstname'),
                    //'enableSorting' => false,
                ],
                
                'lastname' => [
                    'attribute' => 'lastname',
                    'label' => Yii::t('backend', 'Lastname'),
                    //'enableSorting' => false,
                ],            
                
                 'email' => [
                     'attribute' => 'email',
                     'label' => Yii::t('backend', 'Email'),
                     //'enableSorting' => false,
                 ],
                
                 'mobile' => [
                     'attribute' => 'mobile',
                     'label' => Yii::t('backend', 'Mobile'),
                     //'enableSorting' => false,
                 ],
                
                 'status' => [
                    'attribute' => 'status',
                     'label' => Yii::t('backend', 'Status'),
                     'format' => 'html',
                    'value'=> function($model){
                        return  $model->status==10?'<span class="label label-success">'.Yii::t('backend', 'Approved').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'Denied').'</span>';
                    },
                    'enableSorting' => false,
                ],
                
                [
                    'attribute' => 'created_at',
                    'label' => Yii::t('backend', 'Created at'),
                    'format' => ['date', 'php:Y-m-d h:i:s'],
                    'enableSorting' => false,
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                        'template' => $template,
                        'buttons' => [
                            'changepwd' => function ($url, $model, $key) {
                                return  Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, ['title' => Yii::t('backend', 'Change Password')] ) ;
                            },
                         ],                    
                ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
