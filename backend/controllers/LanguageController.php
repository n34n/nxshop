<?php

namespace backend\controllers;

use Yii;
use backend\models\Language;
use backend\models\search\LanguageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Upload;
use mdm\admin\components\AccessControl;
use yii\base\Object;
use yii\web\Cookie;

/**
 * LanguageController implements the CRUD actions for Language model.
 */
class LanguageController extends Controller
{
    /**
     * @inheritdoc
     */
    public $flag_path = 'images/flag/';
    
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
     * Lists all Language models.
     * @return mixed
     */
    public function actionIndex()
    {
  
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Language model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $src = FILE_PATH.$model->icon;

        return $this->render('view', [
            'model' => $model,
            'src'   => $src,
        ]);
    }

    /**
     * Creates a new Language model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Language();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->icon = Upload::uploadImg($model,'icon',$this->flag_path);
            $model->status = $_POST['Language']['status'];
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model      = $this->findModel($id);
        $filename   = $model->icon;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(Upload::uploadImg($model,'icon',$this->flag_path,'update',$filename)){
                
            }
            $model->icon = Upload::uploadImg($model,'icon',$this->flag_path,'update',$filename);
            $model->status = $_POST['Language']['status'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $src = FILE_PATH.$model->icon;
            return $this->render('update', [
                'model' => $model,
                'src'   => $src,
            ]);
        }
    }

    /**
     * Deletes an existing Language model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model      = $this->findModel($id);
        $filename   = $model->icon;
        Upload::deleteImg($filename);
        
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    
    public function actionDeleteimg($id)
    {
        $model = $this->findModel($id);
        Upload::deleteImg($model->icon);
        $model->icon = '';
        $model->save();
        echo json_encode("succ");
    }
    
    public function actionUploadimg($id)
    {
        echo json_encode("succ");
    }    
    
    
    /**
     * set language of cookie for backend user 
     * @param $id
     */
    public function actionChange($id)
    {
        $language=  Yii::$app->request->get('id');
        if(isset($language)){
            //\Yii::$app->session['language']=$language;
            //$_COOKIE['language'] = $language;
            $cookie = new Cookie();
            $cookie->name = 'language';//cookie的名称
            $cookie->expire = time() + 3600*24*30*365; //存活的时间
            $cookie->httpOnly = true; //无法通过js读取cookie
            $cookie->value = $language; //cookie的值
            Yii::$app->response->getCookies()->add($cookie);  
        }

        $this->redirect(Yii::$app->request->headers['Referer']);
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Language the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }   

}
