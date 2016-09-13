<?php

namespace backend\controllers;

use Yii;
use backend\models\Menu;
use backend\models\search\Menu as MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\Helper;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use mdm\admin\components\AccessControl;

/**
 * MenuController implements the CRUD actions for Menu model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MenuController extends Controller
{

    /**
     * @inheritdoc
     */
    protected $_idlist;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
            ],            
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex($id='')
    {
        //list
        $searchModel = new MenuSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        
        $listmodel = new Menu();
        $list = $listmodel->find()->orderBy('parent desc, order asc')->all();
        $list = ArrayHelper::toArray($list);
        $list = ArrayHelper::index($list, null, 'parent');

        $mainmenu = array_pop($list);
        $submenu = $list;
        
        if(isset($_GET['act']) && $_GET['act'] == 'update'){
            $model = $this->findModel($id);
            if ($model->menuParent) {
                $model->parent_name = $model->menuParent->name;
            }            
            if ($model->load(Yii::$app->request->post())){
                    Helper::invalidate();
                    $model->save();
                    return $this->redirect(['index']);
            }
        }else{
            $model = new Menu;
            if ($model->load(Yii::$app->request->post())){
                Helper::invalidate();
                $model->save();
                return $this->redirect(['index']);                
            }
            
            if(isset($_GET['parent_name'])){
                $model->parent_name = $_GET['parent_name'];
            }
        }
        
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'mainmenu'  => $mainmenu,
                'submenu'  => $submenu,
                'model' => $model,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->redirect(['index&act=create']);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->redirect(['index', 'act' => 'update', 'id' => $id]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $idlist = $this->deleteMenus($id);
        $idlist = substr($idlist, 0, -1);
        Menu::deleteAll('id in('.$idlist.')');
        Helper::invalidate();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function deleteMenus($id)
    {
        $this->_idlist .= $id.',';
        $model = Menu::find()->where(['parent'=>$id])->all();

        foreach ($model as $childmodel){
            if(isset($childmodel->id) && $childmodel->id>0){
                $this->deleteMenus($childmodel->id);
            }
        }
        
        return $this->_idlist;
    }
}
