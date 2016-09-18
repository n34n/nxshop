<?php

namespace backend\controllers;

use Yii;
use backend\models\Role;
use backend\models\search\RoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Permissions;
use mdm\admin\components\AccessControl;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
            ],            
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model          = $this->findModel(['=', 'name', $id]);
        
        //get roles
        $searchModel    = new RoleSearch();
        $_roles          = $searchModel->find('name')->Where(['=', 'type', 1])->andWhere(['<>','name',$id])->all();
        foreach ($_roles as $_role){
        	$roles[$_role->group][] = $_role->name;
        }        
        
        //get checked roles
        $permission     = new Permissions();
        $roleschecked   = $permission->find('child')->Where(['=', 'parent', $model->name])->all();
        
        //get permissions
        $searchModel    = new RoleSearch();
        $permissions    = $searchModel->find()
                        ->Where(['=', 'type', 2])
                        ->andWhere(['not like', 'name', 'ctl'])
                        ->andWhere(['not like', 'name', 'gii'])
                        ->andWhere(['not like', 'name', 'debug'])
                        ->all(); 
        
        //get checked permissions
        $permission     = new Permissions();
        $permissionschecked   = $permission->find('child')->Where(['=', 'parent', $model->name])->all();        
        
        
        return $this->render('view', [
            'model'         => $model,
            'roles'         => $roles,
            'roleschecked'  => $roleschecked,
            'permissions'   => $permissions,
            'permissionschecked'   => $permissionschecked,
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        $searchModel = new RoleSearch();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->type        = 1;
            $model->created_at  = $model->updated_at = time();
            $model->save();

            if($_POST['_roles']){
                $_rolesList         = $_POST['_roles'];
                foreach ($_rolesList as $val){
                    $this->savePermissions($model->name,$val);
                }                
            }
            
            if($_POST['Role']['_permissions']){
                $_permissionsList   = $_POST['Role']['_permissions'];
                foreach ($_permissionsList as $val){
                    $this->savePermissions($model->name,$val);
                }
            }     
             
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            $_roles  = $searchModel->find()->Where(['=', 'type', 1])->orderBy('group asc')->all();
            foreach ($_roles as $_role){
            	$roles[$_role->group][] = $_role->name;
            }

            $permissions = $searchModel->find()
            ->Where(['=', 'type', 2])
            ->andWhere(['not like', 'name', 'ctl'])
            ->andWhere(['not like', 'name', 'gii'])
            ->andWhere(['not like', 'name', 'debug'])
            ->all();            
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
                'permissions' => $permissions,
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model          = $this->findModel(['=', 'name', $id]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //delete permissions
            $this->deletePermissions($_POST['Role']['_name']);
           
            $model->updated_at = time();
            $model->save();
            
            if(isset($_POST['_roles']) && !empty($_POST['_roles'])){
                $_rolesList         = $_POST['_roles'];
                foreach ($_rolesList as $val){
                    $this->savePermissions($model->name,$val);
                }
            }
            
            if(isset($_POST['Role']['_permissions']) && !empty($_POST['Role']['_permissions'])){
                $_permissionsList   = $_POST['Role']['_permissions'];
                foreach ($_permissionsList as $val){
                    $this->savePermissions($model->name,$val);
                }
            }            
            
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            //get roles
            $searchModel    = new RoleSearch();
            $_roles          = $searchModel->find('name')->Where(['=', 'type', 1])->andWhere(['<>','name',$id])->all();
            foreach ($_roles as $_role){
            	$roles[$_role->group][] = $_role->name;
            }
            
            //get checked roles
            $permission     = new Permissions();
            $roleschecked   = $permission->find('child')->Where(['=', 'parent', $model->name])->all();
            
            //get permissions
            $searchModel    = new RoleSearch();
            $permissions    = $searchModel->find()
            ->Where(['=', 'type', 2])
            ->andWhere(['not like', 'name', 'ctl'])
            ->andWhere(['not like', 'name', 'gii'])
            ->andWhere(['not like', 'name', 'debug'])
            ->all();
            
            //get checked permissions
            $permission     = new Permissions();
            $permissionschecked   = $permission->find('child')->Where(['=', 'parent', $model->name])->all();
           
            return $this->render('update', [
                'model'         => $model,
                'roles'         => $roles,
                'roleschecked'  => $roleschecked,
                'permissions'   => $permissions,
                'permissionschecked'   => $permissionschecked,
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->deletePermissions($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function savePermissions($parent,$child)
    {
        $model = new Permissions();
        $isExsit = $model::find()->where(['=', 'parent', $parent])
        ->andWhere(['=', 'child', $child])->one();
        if(!$isExsit){
            $model->parent  = $parent;
            $model->child   = $child;            
            $model->save();
        }      
    }
    
    protected function deletePermissions($parent)
    {
        $model = new Permissions();
        $condition = 'parent=:parent';
        $condition .= ' and child not like "%ctl%"';
        $condition .= ' and child not like "%gii%"';
        $condition .= ' and child not like "%debug%"';
        $model->deleteAll($condition, array(':parent'=> $parent));
    }
}
