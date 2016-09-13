<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserLog;

/**
 * UserLogSearch represents the model behind the search form about `backend\models\UserLog`.
 */
class UserLogSearch extends UserLog
{
    /**
     * @inheritdoc
     */
    public $skey;
    public function rules()
    {
        return [
            [['id', 'log_time'], 'integer'],
            [['username', 'action', 'url', 'ip', 'agent', 'get', 'post'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserLog::find();
        
        if(!isset($_GET['sort'])){
            $query->orderBy('log_time DESC');
        }        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '10',
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'log_time' => $this->log_time,
        ]);

        $skey = Yii::$app->request->get('UserLogSearch')['skey'];
        $query->andFilterWhere(['like', 'username',  $skey]);
        $query->orFilterWhere(['like', 'action',  $skey]);

        return $dataProvider;
    }
}
