<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lib_sender".
 * 
 * @property integer $sender_id
 * @property string $type
 * @property string $name
 * @property string $code
 * @property integer $order
 * @property string $disabled
 *
 * @property Product[] $products
 */
class Sender extends \yii\db\ActiveRecord {
	public $file;
	public $img_id;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'lib_sender';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['type','name'],'required'],[['type','disabled'],'string'],[['order'],'integer'],[['name'],'string','max'=>45],[['code'],'string','max'=>20]];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return ['sender_id'=>'Sender ID','type'=>'Type','name'=>'Name','code'=>'Code','order'=>'Order','disabled'=>'Disabled'];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProducts() {
		return $this->hasMany ( Product::className (), ['sender_id'=>'sender_id'] );
	}
}
