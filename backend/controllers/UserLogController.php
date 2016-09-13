<?php

namespace backend\controllers;

use Yii;
use backend\models\UserLog;
use backend\models\search\UserLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\AccessControl;

/**
 * UserLogController implements the CRUD actions for UserLog model.
 */
class UserLogController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
            ],            
        ];
    }

    /**
     * Lists all UserLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->log->targets['db']->enabled = false;
        $searchModel = new UserLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserLog model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->log->targets['db']->enabled = false;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the UserLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
