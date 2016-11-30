<?php

namespace backend\controllers;

use Yii;
use backend\models\Sender;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Images;
use common\components\Upload;
use mdm\admin\components\AccessControl;
/**
 * SenderController implements the CRUD actions for Sender model.
 */
class SenderController extends Controller {
	public $filepath = 'images/sender/';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['verbs'=>['class'=>VerbFilter::className (),'actions'=>['delete'=>['POST']]],'access'=>['class'=>AccessControl::className ()]];
	}
	
	/**
	 * Lists all Sender models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$model = new Sender ();
		$model->file = '';
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET ['id'];
			$model = $this->findModel ( $id );
			$img = Images::find ()->where ( ['model'=>'sender','related_id'=>$id] )->one ();
			
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
				$img->model = 'sender';
				$img->related_id = $related_id;
				$img->path_l = $path_l;
				$img->path_m = $path_m;
				$img->path_s = $path_s;
				$img->created_at = time ();
				$img->save ();
			}
			return $this->redirect ( ['index'] );
		}
		
		$dataProvider = new ActiveDataProvider ( ['query'=>Sender::find(),'pagination'=>['pagesize'=>'10']] );
		
		return $this->render ( 'index', ['model'=>$model,'dataProvider'=>$dataProvider] );
	}
	
	/**
	 * Displays a single Sender model.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', ['model'=>$this->findModel ( $id )] );
	}
	
	/**
	 * Creates a new Sender model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Sender ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( ['view','id'=>$model->sender_id] );
		} else {
			return $this->render ( 'create', ['model'=>$model] );
		}
	}
	
	/**
	 * Updates an existing Sender model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		return $this->redirect ( ['index','id'=>$id] );
	}
	
	/**
	 * Deletes an existing Sender model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * 
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		$img 	= Images::find()->where(['related_id' => $id])->one();
		$this->actionDeleteimg($img->id);
		
		return $this->redirect ( ['index'] );
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
	 * Finds the Sender model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param integer $id
	 * @return Sender the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Sender::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
