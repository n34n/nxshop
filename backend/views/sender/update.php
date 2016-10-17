<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sender */

$this->title = 'Update Sender: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Senders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->sender_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sender-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
