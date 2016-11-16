<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductComment;
use backend\models\search\ProductCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Images;
use common\components\Uploads;
use mdm\admin\components\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * ProductCommentController implements the CRUD actions for ProductComment model.
 */
class ProductCommentController extends Controller {
	public $filepath = 'images/product-comment/';
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['verbs'=>['class'=>VerbFilter::className (),'actions'=>['delete'=>['POST']]],'access'=>['class'=>AccessControl::className ()]];
	}
	
	/**
	 * Lists all ProductComment models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new ProductCommentSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		return $this->render ( '@backend/views/product/comment/index', ['dataProvider'=>$dataProvider] );
	}
	
	/**
	 * Displays a single ProductComment model.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', ['model'=>$this->findModel ( $id )] );
	}
	
	/**
	 * Creates a new ProductComment model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		
		$model = new ProductComment ();
		$model->csi ='5';
		$initialPreviewConfig = array();
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET ['id'];
			$model = $this->findModel ( $id );
			$img = Images::find ()->where ( ['model'=>'product-comment','related_id'=>$id] )->all();
			if ($img) {
				foreach ($img as $k => $v){
					$initialPreviewConfig[$k] = [
							// 要删除商品图的地址
							'url' => 'index.php?r=product-comment/deleteimg&id='.$v['id'],
							// 商品图对应的商品图id
							'key' => $v['id'],
					];
					$model->file[$k] = FILE_PATH .$v['path_m'];
				}
			}
		}
		if ($model->load ( Yii::$app->request->post () ) && $model->validate()) {
			$model->save ();
			if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
				$related_id = $id;
			} else {
				$related_id = Yii::$app->db->getLastInsertID ();
			}
			$file = new Uploads ();
			if ($file->createInstance ( $model, 'file' )) {
				// save file
				$filename = md5 ( $this->filepath . time () );
				$extpath = substr ( $filename, 0, 2 ) . '/' . substr ( $filename, 2, 2 ) . '/';
				$file->saveFile ( $this->filepath.$extpath, $related_id ,$filename );
			}
			return $this->redirect( ['index']);
		}
		return $this->render( '@backend/views/product/comment/create', ['model'=>$model,'initialPreviewConfig'=>$initialPreviewConfig]);
	}
	
	
	//回复
// 	public function actionReply(){
// 		$model = new ProductComment ();
// 		$model->csi ='5';
// 		$initialPreviewConfig = array();
// 		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
// 			$id = $_GET ['id'];
// 			$model = $this->findModel ( $id );
// 			$img = Images::find ()->where ( ['model'=>'product-comment','related_id'=>$id] )->all();
// 			if ($img) {
// 				foreach ($img as $k => $v){
// 					$initialPreviewConfig[$k] = [
// 							// 要删除商品图的地址
// 							'url' => 'index.php?r=product-comment/deleteimg&id='.$v['id'],
// 							// 商品图对应的商品图id
// 							'key' => $v['id'],
// 					];
// 					$model->file[$k] = FILE_PATH .$v['path_m'];
// 				}
// 			}
// 		}
// 		if ($model->load ( Yii::$app->request->post () ) && $model->validate()) {
// 			$model->save ();
// 			if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
// 				$related_id = $id;
// 			} else {
// 				$related_id = Yii::$app->db->getLastInsertID ();
// 			}
// 			$file = new Uploads ();
// 			if ($file->createInstance ( $model, 'file' )) {
// 				// save file
// 				$filename = md5 ( $this->filepath . time () );
// 				$extpath = substr ( $filename, 0, 2 ) . '/' . substr ( $filename, 2, 2 ) . '/';
// 				$file->saveFile ( $this->filepath.$extpath, $related_id ,$filename );
// 			}
// 			return $this->redirect( ['index']);
// 		}
// 		return $this->render( '@backend/views/product/comment/create', ['model'=>$model,'initialPreviewConfig'=>$initialPreviewConfig]);
// 	}
	
	
	
	
	/**
	 * Updates an existing ProductComment model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		return $this->redirect ( ['create','id'=>$id] );
	}
	
	/**
	 * Deletes an existing ProductComment model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		$img 	= Images::find()->where(['related_id' => $id])->all();
		if($img){
			foreach ($img as $k => $v){
				$this->actionDeleteimg($v['id']);
			}
		}
		return $this->redirect ( ['index'] );
	}
	
	
	public function actionDeleteimg($id)
	{
		$model = Images::findOne($id);
		$file  = new Uploads();
		$file->delFile($model->path_l);
		$file->delFile($model->path_m);
		$file->delFile($model->path_s);
		Images::deleteAll('id='.$id);
		echo json_encode("succ");
	}

	/**
	 * Finds the ProductComment model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return ProductComment the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = ProductComment::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
