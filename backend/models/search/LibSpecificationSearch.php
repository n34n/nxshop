<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\LibSpecification;

/**
 * ProductSpecificationSearch represents the model behind the search form about `backend\models\LibSpecification`.
 */
class LibSpecificationSearch extends LibSpecification {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['id','order'],'integer'],[['type','name'],'safe']];
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
	public function search($params,$type) {
		$query = LibSpecification::find ()->where(['type'=>$type]);
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( ['query'=>$query]);
		
		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( ['id'=>$this->id,'order'=>$this->order] );
		
		$query->andFilterWhere ( ['like','type',$this->type] )->andFilterWhere ( ['like','name',$this->name] );
		
		return $dataProvider;
	}
}
