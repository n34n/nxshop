<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

use backend\models\Menu;
use yii\helpers\Json;
use mdm\admin\AutocompleteAsset;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('backend', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
            <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
            
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128])->label(Yii::t('backend', 'Name')); ?>

            <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name'])->label(Yii::t('backend', 'Parent')); ?>

            <?= $form->field($model, 'route')->textInput(['id' => 'route'])->label(Yii::t('backend', 'Route')); ?>

            <?= $form->field($model, 'order')->input('number')->label(Yii::t('backend', 'Order')); ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 4])->label(Yii::t('backend', 'Data')); ?>
            </div>
        </div>
        <div class="form-group" style="padding: 5px 0">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'' : '<i class="fa fa-pencil"> </i> '.Yii::t('backend', 'Update').'', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>         
    </div>
    <?php ActiveForm::end(); ?>
    
    <div class="col-md-6">
    <div class="box box-warning">
        <div class="box-header with-border">
        <?php 
            if(Yii::$app->user->can('角色管理') && isset($_GET['act']) && $_GET['act']=='update'){
                echo Html::a('<i class="fa fa-plus-circle"> </i> '.Yii::t('backend', 'Create').'', ['index'], ['class' => 'btn btn-success btn-sm']);
            }
        ?>    
        </div>
        
        <div class="box-body">
            <table class="table table-striped">
            <tbody>
            <?php
                foreach($mainmenu as $_menu){
                    $json = json_decode($_menu['data']);
                    $icon = '';
                    if(isset($json->icon)){
                        $icon = $json->icon;
                    }

                    //echo $json['icon'];
                    echo "<tr class='bg-gray disabled color-palette'>";
                    echo "<td><i class='".$icon."'>&nbsp;&nbsp;</i>".$_menu['name']."</td>"; 
                    echo '<td style="text-align:right;">
                            <a data-pjax="0" title="新增" href="index.php?r=menu/index&parent_name='.$_menu['name'].'"><span class="glyphicon glyphicon-plus-sign"></span></a> 
                            <a data-pjax="0" title="修改" href="index.php?r=menu/index&act=update&id='.$_menu['id'].'"><span class="glyphicon glyphicon-pencil"></span></a> 
                            <a data-pjax="0" data-confirm="确定要删除该记录吗？" title="删除" href="index.php?r=menu/delete&id='.$_menu['id'].'"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>';
                    echo "</tr>";
    
                    if(isset($submenu[$_menu['id']])){
                        foreach($submenu[$_menu['id']] as $_submenu){
                            $json = json_decode($_submenu['data']);
                            $icon = '';
                            if(isset($json->icon)){
                                $icon = $json->icon;
                            }                            
                            echo "<tr>";
                            echo "<td style='padding-left:40px'><i class='".$icon."'>&nbsp;&nbsp;</i>".$_submenu['name']."</td>";
                            echo '<td style="text-align:right;">
                                   
                                    <a data-pjax="0" title="修改" href="index.php?r=menu/index&act=update&id='.$_submenu['id'].'"><span class="glyphicon glyphicon-pencil"></span></a> 
                                    <a data-pjax="0" data-confirm="确定要删除该记录吗？" title="删除" href="index.php?r=menu/delete&id='.$_submenu['id'].'"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>';
                            echo "</tr>";
                        }                   
                    }

                };
            ?>
            </tbody>
            </table>
        </div>

        </div>
    </div>
    </div>    
</div>
