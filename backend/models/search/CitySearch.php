<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\City;

/**
 * CitySearch represents the model behind the search form about `backend\models\City`.
 */
class CitySearch extends City
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'pid', 'code', 'level', 'order'], 'integer'],
            [['city_name', 'post_code', 'path', 'disabled'], 'safe'],
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
        $query = City::find()->where("level=1");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'city_id' => $this->city_id,
            'pid' => $this->pid,
            'code' => $this->code,
            'level' => $this->level,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'city_name', $this->city_name])
            ->andFilterWhere(['like', 'post_code', $this->post_code])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'disabled', $this->disabled]);

        return $dataProvider;
    }
}
