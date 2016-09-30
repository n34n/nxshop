<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductOrigin */

$this->title = 'Update Product Origin: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Origins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->origin_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-origin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
