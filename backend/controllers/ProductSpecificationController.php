<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductSpecification;
use backend\models\search\ProductSpecificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\AccessControl;

/**
 * ProductSpecificationController implements the CRUD actions for ProductSpecification model.
 */
class ProductSpecificationController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['verbs'=>['class'=>VerbFilter::className (),'actions'=>['delete'=>['POST']]],'access'=>['class'=>AccessControl::className ()]];
	}
	
	/**
	 * Lists all ProductSpecification models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$model = new ProductSpecification ();
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET ['id'];
			$model = $this->findModel ( $id );
		}
		
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			$model->save ();
			
			return $this->redirect ( ['index'] );
		}
		
		$searchModel = new ProductSpecificationSearch ();
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		return $this->render ( '@backend/views/product/specification/index', ['model'=>$model,'dataProvider'=>$dataProvider] );
	}
	
	/**
	 * Displays a single ProductSpecification model.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', ['model'=>$this->findModel ( $id )] );
	}
	
	/**
	 * Creates a new ProductSpecification model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new ProductSpecification ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( ['view','id'=>$model->id] );
		} else {
			return $this->render ( 'create', ['model'=>$model] );
		}
	}
	
	/**
	 * Updates an existing ProductSpecification model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		return $this->redirect ( ['index','id'=>$id] );
	}
	
	/**
	 * Deletes an existing ProductSpecification model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( ['index'] );
	}
	
	/**
	 * Finds the ProductSpecification model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return ProductSpecification the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = ProductSpecification::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
