<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductSpecification;

/**
 * ProductSpecificationSearch represents the model behind the search form about `backend\models\ProductSpecification`.
 */
class ProductSpecificationSearch extends ProductSpecification {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['spec_id','product_id','pid','weight','stock','order'],'integer'],[['name','sku','barcode'],'safe'],[['price','tax_rate'],'number']];
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
	public function search($params,$id=NULL) {
		$query = ProductSpecification::find ()->where(['product_id'=>$id]);
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( ['query'=>$query] );
		
		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( ['spec_id'=>$this->spec_id,'product_id'=>$this->product_id,'pid'=>$this->pid,'price'=>$this->price,'weight'=>$this->weight,'stock'=>$this->stock,'tax_rate'=>$this->tax_rate,'order'=>$this->order] );
		
		$query->andFilterWhere ( ['like','name',$this->name] )->andFilterWhere ( ['like','sku',$this->sku] )->andFilterWhere ( ['like','barcode',$this->barcode] );
		
		return $dataProvider;
	}
}
