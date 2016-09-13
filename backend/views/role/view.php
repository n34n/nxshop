<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

$cssString = '.table-striped > tbody > tr:nth-of-type(odd) {
                  background-color: #e5e5e5;
                }';
$this->registerCss($cssString);
/* @var $this yii\web\View */
/* @var $model backend\models\Role */

$this->title = Yii::t('backend', 'View').' '.Yii::t('backend', 'Roles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
            <p>
            <?php 
                if(Yii::$app->user->can('角色管理')){
                    echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm'])." ";
                    echo Html::a('<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['update', 'id' => $model->name], ['class' => 'btn btn-primary btn-sm'])." ";
                    echo Html::a('<i class="fa fa-trash-o"> </i> '.Yii::t('backend', 'Delete').'', ['delete', 'id' => $model->name], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                }
            ?>
            </p>
            </div>

            <div class=" box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name' => [
                        'attribute' => 'name',
                        'label' => Yii::t('backend', 'Name'),
                    ],
                    'description' => [
                        'attribute' => 'description',
                        'label' => Yii::t('backend', 'Description'),
                        'format' => 'ntext',
                    ], 
                    'rule_name' => [
                        'attribute' => 'rule_name',
                        'label' => Yii::t('backend', 'Rule Name'),
                    ],
                    'created_at' => [
                        'attribute' => 'created_at',
                        'label' => Yii::t('backend', 'Created at'),
                        'format' => ['date', 'php:Y-m-d h:i:s'],
                    ],
                    'updated_at' => [
                        'attribute' => 'updated_at',
                        'label' => Yii::t('backend', 'Updated at'),
                        'format' => ['date', 'php:Y-m-d h:i:s']
                    ],
                ],
            ]) ?>
        
            </div>
            
        <div class="box box-warning">
        <div class="box-body">
            <label class="control-label"><?= Yii::t('backend', 'Roles') ?></label>
            <?php $roles= ArrayHelper::map($roles,'name','name'); ?>
            <?php $roleschecked= ArrayHelper::map($roleschecked,'child','child'); ?>
            <?= Html::checkboxList('roles',$roleschecked,$roles,[
                'class'=> 'checkbox',
                'separator' => '<br/>',
                'itemOptions' => ['disabled'=>'']
            ]) ?>

        </div>
        </div>            
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="box box-warning">
        <div class="box-body">
            <label class="control-label"><?= Yii::t('backend', 'Permissions') ?></label>
            <?php $permissions= ArrayHelper::map($permissions,'name','name'); ?>
            <?php $permissionschecked= ArrayHelper::map($permissionschecked,'child','child'); ?>
            <?= Html::checkboxList('permissions',$permissionschecked,$permissions,[
                'class'=> 'checkbox',
                'separator' => '<br/>',
                'itemOptions' => ['disabled'=>'']
            ]) ?>

        </div>
        </div>            
        </div>
    </div>
    
</div>
