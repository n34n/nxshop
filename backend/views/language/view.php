<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$cssString = '.table-striped > tbody > tr:nth-of-type(odd) {
                  background-color: #e5e5e5;
                }';
$this->registerCss($cssString);

/* @var $this yii\web\View */
/* @var $model backend\models\Language */


$this->title = Yii::t('backend', 'Languages').' ID: '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
    <p>
    <?php 
        if(Yii::$app->user->can('语言设置')){
            echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['create'], ['class' => 'btn btn-success btn-sm'])." ";
            echo Html::a('<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm'])." ";
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
            'language' => [
                'attribute' => 'language',
                'label' => Yii::t('backend', 'Language'),
            ],  
            'code' => [
                'attribute' => 'code',
                'label' => Yii::t('backend', 'Code'),
            ],
            'icon' => [
                'attribute' => 'icon',
                'label' => Yii::t('backend', 'Icon'),
                'format' => 'html',
                'value'  => Html::img($src, array('width'=>'50px')),
            ],            
            'order' => [
                'attribute' => 'order',
                'label' => Yii::t('backend', 'Order'),
            ],
            'status' => [
                'attribute' => 'status',
                'label' => Yii::t('backend', 'Status'),
                'format' => 'html',
                'value'=>  $model->status==10?'<span class="label label-success">'.Yii::t('backend', 'Approved').'</span>':'<span class="label label-danger">'.Yii::t('backend', 'Denied').'</span>',
            ],            

        ],
    ]) ?>
    </div>

</div>
