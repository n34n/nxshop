<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductSpecification;
use backend\models\search\ProductSpecificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductSpecificationController implements the CRUD actions for ProductSpecification model.
 */
class ProductSpecificationController extends Controller
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
//                     'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductSpecification models.
     * @return mixed
     */
    public function actionIndex($id)
    {
    	if (Yii::$app->request->isAjax && $id) {
    		$specModel = new ProductSpecification();
    		$specModel = $specModel->findOne($id);
    		return \yii\helpers\Json::encode($specModel);
    	}
    	return $this->redirect ( ['/product/create'] );
    }

    /**
     * Displays a single ProductSpecification model.
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
     * Creates a new ProductSpecification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
    	$model = new ProductSpecification();
		
    	$model->validate();
    	
    	print_r($model->errors);exit;
    	
    	if(isset($_GET['id'])){
    		$model->product_id = $_GET['id'];
    	}
    	if($model->load ( Yii::$app->request->post ()) && $model->validate()){
    		$post_arr = Yii::$app->request->post ('ProductSpecification');
    		if(empty($post_arr['name'])){
    			$model->name = $post_arr['color'].$post_arr['size'];
    		}
    		$model->barcode = $post_arr['color'].$post_arr['size'];
    		$model->save();
    	}
    	if(isset($_GET['id'])){
    		return $this->redirect ( ['/product/update','id'=>$_GET['id']] );
    	}
    	return $this->redirect ( ['/product/create'] );
    }
	
    public function actionBatchCreate()
    {
    	$model = new ProductSpecification();
    	if(isset($_GET['id'])){
    		$model->product_id = $_GET['id'];
    	}
    	
    	if($model->load ( Yii::$app->request->post ()) && $model->validate()){
    		$post_arr = Yii::$app->request->post ('ProductSpecification');
    		
    		if((empty($post_arr['color'])) or (empty($post_arr['size']))){
    			foreach ($post_arr as $key => $vaule){
    				if(!empty($vaule)){
    					foreach ($vaule as $v){
    						$model->$key 	= $v;
    						$model->name 	= $v;
    						$model->barcode = $v;
    						$_model = clone $model;
    						$_model->save();
    					}
    					 
    				}
    			}
    		}else{
    			foreach ($post_arr['color'] as $color){
    				$model->color = $color;
    				foreach ($post_arr['size'] as  $size){
    					$model->size 	= $size;
    					$model->name 	= $model->color.$model->size;
    					$model->barcode = $model->color.$model->size;
    					$_model = clone $model;
    					$_model->save();
    				}
    			}
    		}
    	}
    	if(isset($_GET['id'])){
    		return $this->redirect ( ['/product/update','id'=>$_GET['id']] );
    	}
    	return $this->redirect ( ['/product/create'] );
    }

    /**
     * Updates an existing ProductSpecification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$model = new ProductSpecification();
    	$model = $model->findOne($id);
    	if($model->load ( Yii::$app->request->post () )){
    		$model->save ();
    	}
    	if($model->product_id){
    		return $this->redirect ( ['/product/update','id'=>$model->product_id] );
    	}
    	return $this->redirect ( ['/product/create'] );
    }

    /**
     * Deletes an existing ProductSpecification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	
    	
    	$model = new ProductSpecification();
    	$object_ret = $model->find()->where('spec_id in ('.$id.')')->one();
    	
    	$product_id = $object_ret->product_id;
    	
    	$model->deleteAll('spec_id in ('.$id.')');
    	
    	if($product_id){
    		return $this->redirect ( ['/product/update','id'=>$product_id] );
    	}
    	return $this->redirect ( ['/product/create'] );
    }

    /**
     * Finds the ProductSpecification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSpecification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSpecification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
