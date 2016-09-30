<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductOrigin */

$this->title = 'Create Product Origin';
$this->params['breadcrumbs'][] = ['label' => 'Product Origins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-origin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
