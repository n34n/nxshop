<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductBrand;
use backend\models\Images;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Upload;
use mdm\admin\components\AccessControl;

/**
 * ProductBrandController implements the CRUD actions for ProductBrand model.
 */
class ProductBrandController extends Controller
{
	public $filepath = 'images/product-brand/';
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
     * Lists all ProductBrand models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$model = new ProductBrand();
    	$model->file = '';
    	
    	if(isset($_GET['id']) && $_GET['id']!=''){
    		$id = $_GET['id'];
    		$model = $this->findModel($id);
    		//print_r($_GET);
    		//echo $model->brand_id;
    		$img = Images::find()->where(['model'=>'product-brand','related_id'=>$id])->one();
    		//print_r($img);die();
    		if($img){
    			$model->img_id	= $img->id;
    			$model->file 	= FILE_PATH.$img->path_m;
    		}
    	}
    	
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		//db save brand
    		$model->save();
    		
    		if(isset($_GET['id']) && $_GET['id']!=''){
    			$related_id = $id;
    		}else{
    			$related_id = Yii::$app->db->getLastInsertID();
    		}
    		
    		$file = new Upload();
    		if($file->createInstance($model,'file')){
    			//save file
    			$filename	= md5($this->filepath.time());
    			$extpath	= substr($filename, 0, 2).'/'.substr($filename, 2, 2).'/';
    			$f 			= $file->saveFile($this->filepath.$extpath,$filename);
    			$path_l = $f['path'].$f['file'];
    			$path_m = $file->thumb($f,'_m',300,300);
    			
    			//db save image
    			$img = new Images();
    			$img->model = 'product-brand';
    			$img->related_id = $related_id;
    			$img->path_l = $path_l;
    			$img->path_m = $path_m;
    			$img->created_at = time();
    			$img->save();    			
    		}
			
    		return $this->redirect(['index']);
    	}else{
    		
    	}
    	
        $dataProvider = new ActiveDataProvider([
            'query' => ProductBrand::find(),
        ]);

        return $this->render('@backend/views/product/brand/index', [
        	'model' => $model,
            'dataProvider' => $dataProvider,
        	
        ]);
    }

    /**
     * Displays a single ProductBrand model.
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
     * Creates a new ProductBrand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductBrand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->brand_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductBrand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->redirect(['index','id' => $id]);
    }

    /**
     * Deletes an existing ProductBrand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$model 	= $this->findModel($id);
    	
    	$img 	= Images::find()->where(['related_id' => $id])->one();
    	$this->actionDeleteimg($img->id);
    	$model->delete();
    	
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public function actionDeleteimg($id)
    {
    	$model = Images::findOne($id);
    	$file  = new Upload();
    	$file->delFile($model->path_l);
    	$file->delFile($model->path_m);
    	$file->delFile($model->path_s);
    	Images::deleteAll('id='.$id);
    	echo json_encode("succ");
    }

    /**
     * Finds the ProductBrand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductBrand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductBrand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
