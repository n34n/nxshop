<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductCategory;
use backend\models\search\ProductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Images;
use common\components\Upload;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;

/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductCategoryController extends Controller {
	public $filepath = 'images/product-category/';
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [ 
				'verbs' => [ 
						'class' => VerbFilter::className (),'actions' => [ ] 
				] 
		]
		// 'delete' => [
		// 'POST'
		// ]
		
		;
	}
	
	/**
	 * Lists all ProductCategory models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$model = new ProductCategory ();
		$model->file = '';
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET ['id'];
			$model = $this->findModel ( $id );
			$img = Images::find ()->where ( [ 
					'model' => 'product-category','related_id' => $id 
			] )->one ();
			if ($img) {
				$model->img_id = $img->id;
				$model->file = FILE_PATH . $img->path_m;
			}
		}
		
		if ($model->load ( Yii::$app->request->post () )) {
			
			$level = $model->find ()->select ( [ 
					'level' 
			] )->where ( [ 
					'category_id' => $model->pid 
			] )->one ();
			
			if (! $level) {
				$model->level = 1;
			} else {
				$model->level = ($level->level) + 1;
			}
			
			Helper::invalidate ();
			$model->save ();
			$category_id = $model->attributes ['category_id'];
			$model->savepath ( $category_id, $model->level );
			
			if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
				$category_id = $id;
			}
			
			// 图片保存
			$file = new Upload ();
			if ($file->createInstance ( $model, 'file' )) {
				// save file
				$filename = md5 ( $this->filepath . time () );
				$extpath = substr ( $filename, 0, 2 ) . '/' . substr ( $filename, 2, 2 ) . '/';
				$f = $file->saveFile ( $this->filepath . $extpath, $filename );
				$path_l = $f ['path'] . $f ['file'];
				$path_m = $file->thumb ( $f, '_m', 300, 300 );
				$path_s = $file->thumb ( $f, '_s', 30, 30 );
				
				// db save image
				$img = new Images ();
				$img->model = 'product-category';
				$img->related_id = $category_id;
				$img->path_l = $path_l;
				$img->path_m = $path_m;
				$img->path_s = $path_s;
				$img->created_at = time ();
				$img->save ();
			}
			return $this->redirect ( [ 
					'index' 
			] );
		}
		$searchModel = new ProductCategorySearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->getQueryParams () );
		
		return $this->render ( '@backend/views/product/category/index', [ 
				'dataProvider' => $dataProvider,'searchModel' => $searchModel,'model' => $model 
		] );
	}
	
	/**
	 * Displays a single ProductCategory model.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', [ 
				'model' => $this->findModel ( $id ) 
		] );
	}
	
	/**
	 * Creates a new ProductCategory model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new ProductCategory ();
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view','id' => $model->category_id 
			] );
		} else {
			return $this->render ( 'create', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Updates an existing ProductCategory model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view','id' => $model->category_id 
			] );
		} else {
			return $this->render ( 'update', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Deletes an existing ProductCategory model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$obj_data = ProductCategory::find ()->where ( [ 
				'category_id' => $id 
		] )->one ();
		$arr_data = ArrayHelper::toArray ( $obj_data );
		
		switch ($arr_data ['level']) {
			case 1 :
				$del_obj_data = ProductCategory::find ()->where ( [ 
						'pid' => $id 
				] )->all ();
				$del_arr_data = ArrayHelper::toArray ( $del_obj_data );
				
				foreach ( $del_arr_data as $k => $v ) {
					$this->findModel ( $v ['category_id'] )->delete ();
					$d_obj_data = ProductCategory::find ()->where ( [ 
							'pid' => $v ['category_id'] 
					] )->all ();
					$d_arr_data = ArrayHelper::toArray ( $d_obj_data );
					foreach ( $d_arr_data as $key => $value ) {
						$this->findModel ( $value ['category_id'] )->delete ();
					}
				}
				$this->findModel ( $id )->delete ();
				break;
			case 2 :
				$del_obj_data = ProductCategory::find ()->where ( [ 
						'pid' => $id 
				] )->all ();
				$del_arr_data = ArrayHelper::toArray ( $del_obj_data );
				foreach ( $del_arr_data as $k => $v ) {
					$this->findModel ( $v ['category_id'] )->delete ();
				}
				break;
			case 3 :
				$this->findModel ( $id )->delete ();
				break;
		}
		return $this->redirect ( [ 
				'index' 
		] );
	}
	
	/**
	 * Finds the ProductCategory model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return ProductCategory the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = ProductCategory::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
