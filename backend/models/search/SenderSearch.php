<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Sender;

/**
 * SenderSearch represents the model behind the search form about `backend\models\Sender`.
 */
class SenderSearch extends Sender {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['sender_id','order'],'integer'],[['type','name','code','disabled'],'safe']];
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios ();
	}
	
	/**
	 * Creates data provider instance with search query applied
	 * 
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = Sender::find ();
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( ['query'=>$query,'pagination'=>['pagesize'=>'10']] );
		
		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( ['sender_id'=>$this->sender_id,'order'=>$this->order] );
		
		$query->andFilterWhere ( ['like','type',$this->type] )->andFilterWhere ( ['like','name',$this->name] )->andFilterWhere ( ['like','code',$this->code] )->andFilterWhere ( ['like','disabled',$this->disabled] );
		
		return $dataProvider;
	}
}
