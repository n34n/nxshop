<?php

namespace backend\controllers;

use Yii;
use backend\models\City;
use backend\models\search\CitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
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
//                     'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
//     public function actionExpand(){
//     	$id = Yii::$app->request->post('expandRowKey');
//     	$dataProvider = new ActiveDataProvider(['query' => City::find()->where("pid='".$id."'")]);
    	
//     	return $this->render('_expand',['dataProvider' => $dataProvider,]);
//     }

    /**
     * Displays a single City model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new City model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new City();
		$model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	$model->save();
        	$id = Yii::$app->db->getLastInsertID();
        	$pid = Yii::$app->request->post('City')['pid'];
        	
        	if($pid){
        		$arr = $model->find()->where('city_id=:city_id')->addParams([':city_id' => $pid])->one();
        		$model->path = $arr->path.$id.',';
        		$model->level = $arr->level+1;
        	}else {
        		$model->path = ','.$id.',';
        	}
        	$model->save();
        	
        	$searchModel = new CitySearch();
        	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        	
        	return $this->redirect ( ['index'] );
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    
    /**
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	$this->saveCity($model,$id);
        	$searchModel = new CitySearch();
        	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        	return $this->redirect ( ['index'] );
        } else {
            return $this->render('update', ['model' => $model,]);
        }
    }

    private static function saveCity($model,$id){
    	$arr = City::find()->where('city_id=:city_id')->addParams([':city_id' => $model->pid])->one();
    	if($arr){
    		$model->path = $arr->path.$id.',';
    		$model->level = $arr->level+1;
    	}else{
    		$model->path = ','.$id.',';
    		$model->level = 1;
    	}
    	$model->save();
    	$_model = City::find()->where('pid=:pid')->addParams([':pid' => $id])->all();
    	if($_model){
    		foreach ($_model as $m){
    			self::saveCity($m, $m->city_id);
    		}
    	}
		return ;
    }
    
    
    
    
    /**
     * Deletes an existing City model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$this->delCity($id);
        return $this->redirect(['index']);
    }
    
    private static function delCity($id){
    	$_model = City::find()->where('pid=:pid')->addParams([':pid' => $id])->all();
    	if($_model){
    		foreach ($_model as $m){
    			self::delCity($m->city_id);
    		}
    	}
		City::findOne($id)->delete();
    	return ;
    }
    

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    public function actionChildCity() {
    	$out = [];
    	if (isset($_POST['depdrop_parents'])) {
    		$id = end($_POST['depdrop_parents']);
    		$list = City::find()->andWhere(['pid'=>$id])->asArray()->all();
    		$selected  = null;
    		if ($id != null && count($list) > 0) {
    			$selected = '';
    			foreach ($list as $i => $account) {
    				$out[] = ['id' => $account['city_id'], 'name' => $account['city_name']];
    				if ($i == 0) {
    					$selected = $account['city_id'];
    				}
    			}
    			// Shows how you can preselect a value
    			echo Json::encode(['output' => $out, 'selected'=>$selected]);
    			return;
    		}
    	}
    	echo Json::encode(['output' => '', 'selected'=>'']);
    }
    
    
    
    
}
