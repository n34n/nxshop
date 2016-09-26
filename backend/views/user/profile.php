<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use hyii2\avatar\AvatarWidget;
use yii\helpers\ArrayHelper;

$cssString = '.table-striped > tbody > tr:nth-of-type(odd) {
                  background-color: #e5e5e5;
                }';
$this->registerCss($cssString);

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('backend', 'Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'My Account'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-3">
<div class="box"> 
    <div class=" box-body">
    <?= AvatarWidget::widget(['imageUrl'=> (isset($img) && $img!='')?FILE_PATH.$img->path_l:DEFAULT_AVATAR]); ?>
    </div>
      

</div>
</div>

<div class="col-md-9">
<div class="box"> 
    <div class=" box-body">
    <?= DetailView::widget([
        'model' => $model,
        
        'attributes' => [
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
    
    <div class="box-header">
        <?php
        echo Html::a('<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['update-profile', 'id' => $model->id, 'act'=>''], ['class' => 'btn btn-primary btn-sm'])." ";
        echo Html::a('<i class="fa fa-lock"> </i> '.Yii::t('backend', 'Change Password').'', ['update-profile', 'id' => $model->id, 'act'=>'-pwd'], ['class' => 'btn btn-warning btn-sm'])." ";    
        ?>
    </div>    

</div>
</div>
