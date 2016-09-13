<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('backend', 'Create').' '.Yii::t('backend', 'User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= $this->render('_form', [
	'roles' => $roles,
    'model' => $model,
]) ?>


