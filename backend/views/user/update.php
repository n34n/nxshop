<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('backend', 'Update').' '.Yii::t('backend', 'User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <?= $this->render('_formupdate', [
        'model' => $model,
        'roles' => $roles,
        'roleschecked'  => $roleschecked,
    ]) ?>

</div>
