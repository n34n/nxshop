<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sender */

$this->title = 'Create Sender';
$this->params['breadcrumbs'][] = ['label' => 'Senders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sender-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
