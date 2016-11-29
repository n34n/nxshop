<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\ProductSpecification;
use backend\models\search\ProductSpecificationSearch;
use common\components\Upload;
use common\components\Uploads;
use backend\models\Images;
use yii\helpers\ArrayHelper;
use backend\models\ProductRelTag;
use backend\models\ProductRelCate;
use backend\models\ProductKeyword;
use mdm\admin\components\AccessControl;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {
	public $filepath = 'images/product/';
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['verbs'=>['class'=>VerbFilter::className (),'actions'=>['delete'=>['POST']]],'access'=>['class'=>AccessControl::className ()]];
	}
	
	/**
	 * @ajax表单异步验证
	 */
// 	public function actionValidateForm() {
// 		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// 		$model = new ProductSpecification ();
// 		$model->load ( Yii::$app->request->post () );
// 		return \yii\widgets\ActiveForm::validate ( $model );
// 	}
	
	/**
	 * Lists all Product models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new ProductSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		return $this->render ( 'index', ['searchModel'=>$searchModel,'dataProvider'=>$dataProvider] );
	}
	
	/**
	 * Displays a single Product model.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', ['model'=>$this->findModel ( $id )] );
	}
	
	/**
	 * Creates a new Product model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Product ();
		$model->loadDefaultValues ();
		$specModel = new ProductSpecification ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			$model->save ();
			$product_id = Yii::$app->db->getLastInsertID ();
			// 关键字添加
			if (Yii::$app->request->post ( 'Product' ) ['skey']) {
				$skey = explode ( '|', Yii::$app->request->post ( 'Product' ) ['skey'] );
				$model->saveRelationId ( $skey, ProductKeyword::tableName (), $product_id, 'keyword' );
			}
			// 商品关联添加
			$model->saveRelationId ( Yii::$app->request->post ( 'Product' ) ['tag_id'], ProductRelTag::tableName (), $product_id, 'tag_id' );
			$model->saveRelationId ( Yii::$app->request->post ( 'Product' ) ['category_id'], ProductRelCate::tableName (), $product_id, 'category_id' );
			// 商品多规格添加
			if (Yii::$app->request->post ( 'Product' ) ['is_multi_spec'] == 'Y') {
				$spec_ids = Yii::$app->request->post ( 'multiple_spec_id' );
				foreach ( $spec_ids as $spec_id ) {
					if ($spec_id) {
						$specModel = $specModel->findOne ( $spec_id );
						$specModel->product_id = $product_id;
						$specModel->save ();
					}
				}
			}
			
			// 创建主图
			$file = new Uploads ();
			if ($file->createInstance ( $model, 'file' )) {
				// save file
				$filename = md5 ( $this->filepath . time () );
				$extpath = substr ( $filename, 0, 2 ) . '/' . substr ( $filename, 2, 2 ) . '/';
				$file->saveFile ( $this->filepath . $extpath, $product_id, "product", $filename );
			}
			return $this->redirect ( ['index'] );
		}
		// 渲染
		$specSearchModel = new ProductSpecificationSearch ();
		$specDataProvider = $specSearchModel->search ( Yii::$app->request->queryParams, 0 );
		if ($specModel->getSpec_id ()) {
			$model->is_multi_spec = "Y";
		}
		return $this->render ( 'create', ['model'=>$model,'specModel'=>$specModel,'specDataProvider'=>$specDataProvider] );
	}
	
	/**
	 * Updates an existing Product model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		$img = Images::find ()->where ( ['model'=>'product','related_id'=>$id] )->all ();
		$initialPreviewConfig = '';
		if ($img) {
			foreach ( $img as $k => $v ) {
				$initialPreviewConfig [$k] = [				// 要删除商品图的地址
				'url'=>'index.php?r=product-comment/deleteimg&id=' . $v ['id'],
						// 商品图对应的商品图id
						'key'=>$v ['id']];
				$model->file [$k] = FILE_PATH . $v ['path_m'];
			}
		}
		$model->category_id = ArrayHelper::getColumn ( $model->getCategories ()->select ( 'category_id' )->asArray ()->all (), 'category_id' );
		$model->tag_id = ArrayHelper::getColumn ( $model->getTags ()->select ( 'tag_id' )->asArray ()->all (), 'tag_id' );
		$model->skey = $model->getskey ();
		
		$specModel = new ProductSpecification ();
		$specSearchModel = new ProductSpecificationSearch ();
		$specDataProvider = $specSearchModel->search ( Yii::$app->request->queryParams, $id );
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			// 更新 关联，并删除原关联
			if (Yii::$app->request->post ( 'Product' ) ['skey']) {
				$skey = explode ( '|', Yii::$app->request->post ( 'Product' ) ['skey'] );
				$model->saveRelationId ( $skey, ProductKeyword::tableName (), $id, 'keyword', true );
			}
			$model->saveRelationId ( Yii::$app->request->post ( 'Product' ) ['tag_id'], ProductRelTag::tableName (), $id, 'tag_id', true );
			$model->saveRelationId ( Yii::$app->request->post ( 'Product' ) ['category_id'], ProductRelCate::tableName (), $id, 'category_id', true );
			$file = new Uploads ();
			if ($file->createInstance ( $model, 'file' )) {
				// save file
				$filename = md5 ( $this->filepath . time () );
				$extpath = substr ( $filename, 0, 2 ) . '/' . substr ( $filename, 2, 2 ) . '/';
				$file->saveFile ( $this->filepath . $extpath, $id, "product", $filename );
			}
			return $this->redirect ( ['update','id'=>$model->product_id] );
		} else {
			return $this->render ( 'update', ['model'=>$model,'specModel'=>$specModel,'specDataProvider'=>$specDataProvider,'initialPreviewConfig'=>$initialPreviewConfig] );
		}
	}
	
	/**
	 * Deletes an existing Product model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		$img = Images::find ()->where ( ['related_id'=>$id] )->one ();
		if ($img) {
			$this->actionDeleteimg ( $img->id );
		}
		return $this->redirect ( ['index'] );
	}
	
	
	public function actionDeleteimg($id) {
		$model = Images::findOne ( $id );
		$file = new Upload ();
		$file->delFile ( $model->path_l );
		$file->delFile ( $model->path_m );
		$file->delFile ( $model->path_s );
		Images::deleteAll ( 'id=' . $id );
		echo json_encode ( "succ" );
	}
	
	/**
	 * Finds the Product model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return Product the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Product::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
