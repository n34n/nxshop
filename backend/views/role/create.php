<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Role */

$this->title = Yii::t('backend', 'Create').' '.Yii::t('backend', 'Roles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'roles' => $roles,
    'permissions' => $permissions,
]) ?>