<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductOrigin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Origins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-origin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->origin_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->origin_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'origin_id',
            'name',
            'order',
            'disabled',
        ],
    ]) ?>

</div>
