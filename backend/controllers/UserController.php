<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\AccessControl;
//use yii\base\Action;
//use hyii2\avatar\CropAction;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                       //'delete' => ['POST'],
                 ],
             ],
            'access' => [
                'class' => AccessControl::className(),
             ], 

        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $template = '';
        if(Yii::$app->user->can('用户查看')){
            $template = '{view}';
        }
        
        if(Yii::$app->user->can('用户编辑')){
            $template = '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{changepwd}';
        }   
        
        if(Yii::$app->user->can('用户管理') || Yii::$app->user->can('admin')){
            $template = '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{changepwd}&nbsp;&nbsp;{delete}';
        }        
        
       //echo '123'.$template;die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template' => $template,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new User();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->generateAuthKey();
            $model->auth_key = $model->getAuthKey();
            $model->setPassword($_POST['User']['password']);
            $model->status = $_POST['User']['status'];
            $model->created_at = $model->updated_at = time();
            $model->save();

            //header("Content-type:text/html;charset=utf-8");
            $userid  = $model->getPrimaryKey();
            $manager = Yii::$app->getAuthManager();
            if(isset($_POST['User']['_roles']) && !empty($_POST['User']['_roles'])){
                foreach ($_POST['User']['_roles'] as $_role) {
                    $role =Yii::$app->authManager->getRole($_role);
                    $manager->assign($role,$userid);
                }            
            }

            return $this->redirect(['index']);
        }else{
            $manager = Yii::$app->getAuthManager();
            $roles = $manager->getRoles();
            $errors = $model->errors;
        }
        
        return $this->render('create', [
            'roles' => $roles,
            'model' => $model,
        ]);            

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->status = $_POST['User']['status'];
            $model->updated_at = time();
            $model->save();

            $manager = Yii::$app->getAuthManager();
            $manager->revokeAll($id);
            if(isset($_POST['User']['_roles']) && !empty($_POST['User']['_roles'])){
                foreach ($_POST['User']['_roles'] as $_role) {
                    $role =Yii::$app->authManager->getRole($_role);
                    $manager->assign($role,$id);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $manager        = Yii::$app->getAuthManager();
            $roles          = $manager->getRoles();
            $roleschecked   = $manager->getRolesByUser($id);
            //print_r($roleschecked);die();
            return $this->render('update', [
                'model' => $model,
                'roles' => $roles,
                'roleschecked'  => $roleschecked,
            ]);
        }
    }
    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateProfile($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updated_at = time();
            if(isset($_POST['User']['password']) && $_POST['User']['password']!=''){
                $model->password = $model->setPassword($_POST['User']['password']);
            }
            $model->save();

            return $this->redirect(['profile']);
        } else {
            $action = Yii::$app->controller->action->id.$_GET['act'];
            return $this->render($action, [
                'model' => $model,
            ]);
        }
    }  
    
    public function actionChangepwd($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updated_at = time();
            $model->password = $model->setPassword($_POST['User']['password']);
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('changepwd', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public function actionProfile()
    {
        $id = Yii::$app->user->id;
        //$model = $this->findModel($id);
        
        $model = User::find()->joinWith('images')->where(['user.id'=>$id])->one();
               
        if(isset($model->images)){
            $img = $model->images;
        }else{
            $img ='';
        }

        return $this->render('profile', [
            'model' => $model,
            'img' => $img,
        ]); 
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'hyii2\avatar\CropAction',
                'config'=>[
                    'bigImageWidth' => '200',     //大图默认宽度
                    'bigImageHeight' => '200',    //大图默认高度
                    'middleImageWidth'=> '100',   //中图默认宽度
                    'middleImageHeight'=> '100',  //中图图默认高度
                    'smallImageWidth' => '50',    //小图默认宽度
                    'smallImageHeight' => '50',   //小图默认高度
                    //头像上传目录（注：目录前不能加"/"）
                    'uploadPath' => '../../uploads/images/avatar',
                    'model' => 'user',
                ],
            ]
        ];
    } 
      
}
