<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_specification".
 *
 * @property integer $spec_id
 * @property integer $product_id
 * @property integer $pid
 * @property string $name
 * @property string $size
 * @property string $color
 * @property string $sku
 * @property string $barcode
 * @property string $price
 * @property integer $weight
 * @property integer $stock
 * @property string $tax_rate
 * @property integer $order
 */
class ProductSpecification extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'product_specification';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[[ 'size','color'], 'required'],
// 				['name', 'unique', 'message'=>'{attribute}已存在',],
				[['pid', 'weight', 'stock', 'order'], 'integer'],
				[['price', 'tax_rate'], 'number'],
				[['name'], 'string', 'max' => 45],
				[['sku', 'barcode'], 'string', 'max' => 20],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
				'spec_id' => 'Spec ID',
				'product_id' => 'Product ID',
				'pid' => 'Pid',
				'name' => 'Name',
				'size' => 'Size',
				'color' => 'Color',
				'sku' => 'Sku',
				'barcode' => 'Barcode',
				'price' => 'Price',
				'weight' => 'Weight',
				'stock' => 'Stock',
				'tax_rate' => 'Tax Rate',
				'order' => 'Order',
		];
	}
	
	
	
	public function getSpec_id($id='0'){
		$model = $this->find()->select('spec_id')->where(['product_id'=>$id])->all();
		$spec_ids = '';
		foreach ($model as $k){
			$spec_ids .= $k->spec_id.',';
		}
		return $spec_ids;
	}
	
}