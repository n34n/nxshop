<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use backend\models\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'homeLink' => [
                    'label' => Yii::t('backend', 'Home'),  // required
                    'url' => './',      // optional, will be processed by Url::to()
                    'template' => '<li><i class="fa fa-home"> </i> {link}</li>', // optional, if not set $this->itemTemplate will be used
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>



<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">

    <!-- Tab panes -->
    <div class="tab-content">

        <div>
            <ul class="list-unstyled">
            <?php 
            //Language::get
                $query = Language::find()->joinWith('images')->where(['language.status'=>'10'])->select(['language.language','language.code','images.path_s'])->orderBy('language.order ASC');
                $obj = $query->all();
                foreach ($obj as $language){
					echo '<li>';
					$src = FILE_PATH.$language->path_s;
					$img =  Html::img($src);
					echo Html::a($img, ['language/change', 'id'=> $language->code], ['class' => 'btn']);
					echo $language->language;
					echo '</li>';
                }
            ?>
            </ul>
        </div>

    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>