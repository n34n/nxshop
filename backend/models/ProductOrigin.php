<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_origin".
 * 
 * @property integer $origin_id
 * @property string $name
 * @property integer $order
 * @property string $disabled
 *
 * @property Product[] $products
 */
class ProductOrigin extends \yii\db\ActiveRecord {
	public $filename;
	public $file;
	public $img_id;
	public $id;
	public $path_s;
	
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'product_origin';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'name',
								'order',
								'disabled' 
						],
						'required' 
				],
				[ 
						[ 
								'order' 
						],
						'integer' 
				],
				[ 
						[ 
								'disabled' 
						],
						'string' 
				],
				[ 
						[ 
								'name' 
						],
						'string',
						'max' => 50 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'origin_id' => 'Origin ID',
				'name' => 'Name',
				'order' => 'Order',
				'disabled' => 'Disabled' 
		];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProducts() {
		return $this->hasMany ( Product::className (), [ 
				'origin_id' => 'origin_id' 
		] );
	}
	public function getImages() {
		/**
		 * 第一个参数为要关联的字表模型类名称，
		 * 第二个参数指定 通过子表的 id 去关联主表的 id 字段
		 */
		return $this->hasOne ( Images::className (), [ 
				'related_id' => 'origin_id' 
		] )->onCondition ( [ 
				'images.model' => 'product-origin' 
		] );
	}
}
