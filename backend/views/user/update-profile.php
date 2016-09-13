<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('backend', 'Update').' '.Yii::t('backend', 'Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'My Account'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
