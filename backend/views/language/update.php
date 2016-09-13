<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Language */

$this->title = Yii::t('backend', 'Update').' '.Yii::t('backend', 'Languages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Languages'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-update">

    <?= $this->render('_form', [
        'model' => $model,
        'src'   => $src,
    ]) ?>

</div>
