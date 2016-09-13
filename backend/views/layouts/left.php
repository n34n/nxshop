<?php
use yii\bootstrap\Nav;
use mdm\admin\components\MenuHelper;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

<?php
$callback = function($menu){
    $data = json_decode($menu['data'], true);
    $items = $menu['children'];
    $_actived = explode('/', Yii::$app->controller->route);
    $_route   = explode('/', substr($menu['route'],1));

    if($_actived[0] == $_route[0]){
        $return = [
            'label' => Yii::t('menu', $menu['name']),
            'url' => [$menu['route']],
            'active' => 1,
        ];
    }else{
        $return = [
            'label' => Yii::t('menu', $menu['name']),
            'url' => [$menu['route']],
        ];        
    }


    if ($data) {
        //visible
        isset($data['visible']) && $return['visible'] = $data['visible'];
        //icon
        isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
        //other attribute e.g. class...
        $return['options'] = $data;
    }

    (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
    $items && $return['items'] = $items;
    return $return;
};

echo dmstr\widgets\Menu::widget( [ 
    'options' => ['class' => 'sidebar-menu'], 
    'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback), 
] ); ?>

    </section>

</aside>
