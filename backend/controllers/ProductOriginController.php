<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductOrigin;
use backend\models\search\ProductOriginSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Images;
use common\components\Upload;

/**
 * ProductOriginController implements the CRUD actions for ProductOrigin model.
 */
class ProductOriginController extends Controller {
	public $filepath = 'images/product-origin/';
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [ 
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'delete' => [ 
										'POST' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * Lists all ProductOrigin models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$model = new ProductOrigin ();
		$model->file = '';
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET ['id'];
			$model = $this->findModel ( $id );
			$img = Images::find ()->where ( [ 
					'model' => 'product-origin',
					'related_id' => $id 
			] )->one ();
			if ($img) {
				$model->img_id = $img->id;
				$model->file = FILE_PATH . $img->path_m;
			}
		}
		
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			$model->save ();
			if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
				$related_id = $id;
			} else {
				$related_id = Yii::$app->db->getLastInsertID ();
			}
			
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
				$img->model = 'product-origin';
				$img->related_id = $related_id;
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
		
		$searchModel = new ProductOriginSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		return $this->render ( '@backend/views/product/origin/index', [ 
				'model' => $model,
				'dataProvider' => $dataProvider 
		] );
	}
	
	/**
	 * Displays a single ProductOrigin model.
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
	 * Creates a new ProductOrigin model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new ProductOrigin ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view',
					'id' => $model->origin_id 
			] );
		} else {
			return $this->render ( 'create', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Updates an existing ProductOrigin model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		return $this->redirect ( [ 
				'index',
				'id' => $id 
		] );
	}
	
	/**
	 * Deletes an existing ProductOrigin model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( [ 
				'index' 
		] );
	}
	
	/**
	 * Finds the ProductOrigin model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return ProductOrigin the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = ProductOrigin::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
