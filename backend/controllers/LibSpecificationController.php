<?php

namespace backend\controllers;

use Yii;
use backend\models\LibSpecification;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\AccessControl;

/**
 * LibSpecificationController implements the CRUD actions for LibSpecification model.
 */
class LibSpecificationController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['verbs'=>['class'=>VerbFilter::className (),'actions'=>['delete'=>['POST']]],'access'=>['class'=>AccessControl::className ()]];
	}

	/**
	 * Lists all LibSpecification models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$dataProviderSize = new ActiveDataProvider(['query' => LibSpecification::find()->where("type= 'size'"),]);
		$dataProviderColor = new ActiveDataProvider(['query' => LibSpecification::find()->where("type= 'color'"),]);
		return $this->render ( '@backend/views/product/specification/index', ['dataProviderSize'=>$dataProviderSize,'dataProviderColor'=>$dataProviderColor] );
	}

	/**
	 * Displays a single LibSpecification model.
	 *
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', ['model'=>$this->findModel ( $id )] );
	}

	/**
	 * Creates a new LibSpecification model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new LibSpecification ();
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET ['id'];
			$model = $this->findModel ( $id );
		}
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( ['index'] );
		} else {
			return $this->render ( '@backend/views/product/specification/create', ['model'=>$model] );
		}
	}

	/**
	 * Updates an existing LibSpecification model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		return $this->redirect ( ['create','id'=>$id] );
	}

	/**
	 * Deletes an existing LibSpecification model.
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
	 * Finds the LibSpecification model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 * @return LibSpecification the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = LibSpecification::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
