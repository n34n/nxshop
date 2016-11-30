<?php

namespace backend\controllers;

use Yii;
use backend\models\Tag;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\AccessControl;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller {
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['verbs'=>['class'=>VerbFilter::className (),'actions'=>['delete'=>['POST']]],'access'=>['class'=>AccessControl::className ()]];
	}
	
	/**
	 * Lists all Tag models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$model = new Tag ();
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			
			$model = $this->findModel ( $_GET ['id'] );
		}
		
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			
			$model->save ();
			
			return $this->redirect ( ['index'] );
		}
		
		$dataProvider = new ActiveDataProvider(['query' => Tag::find(),'pagination'=>['pagesize'=>'10']]);
		
		return $this->render ( 'index', ['model'=>$model,'dataProvider'=>$dataProvider] );
	}
	
	/**
	 * Displays a single Tag model.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', ['model'=>$this->findModel ( $id )] );
	}
	
	/**
	 * Creates a new Tag model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Tag ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( ['view','id'=>$model->tag_id] );
		} else {
			return $this->render ( 'create', ['model'=>$model] );
		}
	}
	
	/**
	 * Updates an existing Tag model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		return $this->redirect ( ['index','id'=>$id] );
	}
	
	/**
	 * Deletes an existing Tag model.
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
	 * Finds the Tag model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return Tag the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Tag::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
