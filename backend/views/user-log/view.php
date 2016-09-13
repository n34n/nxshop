<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserLog */

$this->title = Yii::t('backend', 'View').' '.Yii::t('backend', 'Logs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User').' '.Yii::t('backend', 'Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username' => [
                'attribute' => 'username',
                'label' => Yii::t('backend', 'Username'),
            ],            
            'action' => [
                'attribute' => 'action',
                'label' => Yii::t('backend', 'Action'),
            ],            
            'url' => [
                'attribute' => 'url',
                'label' => Yii::t('backend', 'URL'),
                'format' => 'url',
            ],            
            'ip' => [
                'attribute' => 'ip',
                'label' => Yii::t('backend', 'IP'),
            ],  
            'agent' => [
                'attribute' => 'agent',
                'label' => Yii::t('backend', 'Agent'),
            ],            
            'get' => [
                'attribute' => 'get',
                'label' => Yii::t('backend', 'Get'),
                'format' => 'ntext',
            ], 
            'post' => [
                'attribute' => 'post',
                'label' => Yii::t('backend', 'Post'),
                'format' => 'ntext',
            ],            
            'log_time' => [
                'attribute' => 'log_time',
                'label' => Yii::t('backend', 'Date'),
                'format' => 'datetime',
            ],
        ],
    ]) ?>

</div>
