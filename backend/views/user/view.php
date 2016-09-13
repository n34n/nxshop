<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$cssString = '.table-striped > tbody > tr:nth-of-type(odd) {
                  background-color: #e5e5e5;
                }';
$this->registerCss($cssString);

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('backend', 'User').' ID: '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header with-border">
    <p>
    <?php 
        if(Yii::$app->user->can('用户编辑')){
            echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm'])." ";
            echo Html::a('<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm'])." ";
            echo Html::a('<i class="fa fa-lock"> </i> '.Yii::t('backend', 'Change Password').'', ['changepwd', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm'])." ";
        }
        
        if(Yii::$app->user->can('用户管理') || Yii::$app->user->can('admin')){
            echo Html::a('<i class="fa fa-trash-o"> </i> '.Yii::t('backend', 'Delete').'', ['delete', 'id' => $model->id], [
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
            'id',
            'username' => [
                'attribute' => 'username',
                'label' => Yii::t('backend', 'Username'),
                //'enableSorting' => false,
            ],
            
            'firstname' => [
                'attribute' => 'firstname',
                'label' => Yii::t('backend', 'Firstname'),
            ],
            
            'lastname' => [
                'attribute' => 'lastname',
                'label' => Yii::t('backend', 'Lastname'),
            ],            
            
            'email' => [
                'attribute' => 'email',
                'label' => Yii::t('backend', 'Email'),
                'format' => 'email',
                //'enableSorting' => false,
            ],            
            'mobile' => [
                'attribute' => 'mobile',
                'label' => Yii::t('backend', 'Mobile'),
            ],
            'status' => [
                'attribute' => 'status',
                'label' => Yii::t('backend', 'Status'),
                'format' => 'html',
                'value'=>  $model->status==10?'<span class="label label-success">'.Yii::t('backend', 'Approved').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'Denied').'</span>',
            ],
            
            [
                'attribute' => 'created_at',
                'label' => Yii::t('backend', 'Created at'),
                'format' => ['date', 'php:Y-m-d h:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => Yii::t('backend', 'Updated at'),
                'format' => ['date', 'php:Y-m-d h:i:s']
            ],
        ],
    ]) ?>
    </div>

</div>
