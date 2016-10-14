<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tag;

/**
 * TagSearch represents the model behind the search form about `backend\models\Tag`.
 */
class TagSearch extends Tag {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'tag_id' 
						],'integer' 
				],[ 
						[ 
								'name','type' 
						],'safe' 
				] 
		];
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
		$query = Tag::find ();
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query,'pagination' => [ 
						'pagesize' => '10' 
				] 
		] );
		
		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( [ 
				'tag_id' => $this->tag_id 
		] );
		
		$query->andFilterWhere ( [ 
				'like','name',$this->name 
		] )->andFilterWhere ( [ 
				'like','type',$this->type 
		] );
		
		return $dataProvider;
	}
}
