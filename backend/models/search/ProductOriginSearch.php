<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductOrigin;

/**
 * ProductOriginSearch represents the model behind the search form about `backend\models\ProductOrigin`.
 */
class ProductOriginSearch extends ProductOrigin {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['origin_id','order'],'integer'],[['name','disabled'],'safe']];
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
		$query = ProductOrigin::find ()->joinWith ( ['images'] )->select ( ['product_origin.*','images.id as img_id','images.path_s'] );
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( ['query'=>$query,'pagination'=>['pagesize'=>'10']] );
		
		$this->load ( $params );
		
		// uncomment the following line if you do not want to return any records when validation fails
		
		if (! $this->validate ()) {
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( ['origin_id'=>$this->origin_id,'order'=>$this->order] );
		
		$query->andFilterWhere ( ['like','name',$this->name] )->andFilterWhere ( ['like','disabled',$this->disabled] );
		
		return $dataProvider;
	}
}
