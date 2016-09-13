<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('backend', 'Change Password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'My Account'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <?= $this->render('_formpwd', [
        'model' => $model,
    ]) ?>

</div>
