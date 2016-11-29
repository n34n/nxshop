<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;
use yii\helpers\ArrayHelper;

/**
 * ProductSearch represents the model behind the search form about `backend\models\Product`.
 */
class ProductSearch extends Product {
	/**
	 * @inheritdoc
	 */
	public $skey;
	public function rules() {
		return [[['product_id','brand_id','origin_id','weight','stock','sender_id','online_scheduled','created_at','updated_at'],'integer'],[['title','subtitle','sku','barcode','is_multi_spec','specification','is_cross_border','details','online','created_by','updated_by'],'safe'],[['price','tax_rate'],'number']];
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

		$query = Product::find()->joinWith('categories')->joinWith('keyword');

		if(!isset($_GET['sort'])){
			$query->orderBy('product_id DESC');
		}
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider ( ['query'=>$query,'pagination'=>['pagesize'=>'10']] );

		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere ( [
					'product_id'=>$this->product_id,
					'brand_id'=>$this->brand_id,
					'origin_id'=>$this->origin_id,
					'price'=>$this->price,
					'weight'=>$this->weight,
					'stock'=>$this->stock,
					'sender_id'=>$this->sender_id,
					'tax_rate'=>$this->tax_rate,
					'online_scheduled'=>$this->online_scheduled,
					'created_at'=>$this->created_at,
					'updated_at'=>$this->updated_at,
				]);

		
		$skey = Yii::$app->request->get('ProductSearch')['skey'];
		$query->andFilterWhere ( ['like','title',$this->title] )
		->andFilterWhere ( ['like','subtitle',$this->subtitle] )
		->andFilterWhere ( ['like','sku',$this->sku] )
		->andFilterWhere ( ['like','barcode',$this->barcode] )
		->andFilterWhere ( ['like','is_multi_spec',$this->is_multi_spec] )
		->andFilterWhere ( ['like','specification',$this->specification] )
		->andFilterWhere ( ['like','is_cross_border',$this->is_cross_border] )
		->andFilterWhere ( ['like','details',$this->details] )
		->andFilterWhere ( ['like','online',$this->online] )
		->andFilterWhere ( ['like','created_by',$this->created_by] )
		->andFilterWhere ( ['like','updated_by',$this->updated_by] )
		->orFilterWhere ( ['like','product_keyword.keyword',$skey] );

		return $dataProvider;
	}
}
