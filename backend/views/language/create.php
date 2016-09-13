<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Language */

$this->title = Yii::t('backend', 'Create').' '.Yii::t('backend', 'Languages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>


