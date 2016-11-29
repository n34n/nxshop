<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\search\ProductSearch;

/**
 * This is the model class for table "product".
 * 
 * @property integer $product_id
 * @property string $title
 * @property string $subtitle
 * @property string $sku
 * @property string $barcode
 * @property integer $brand_id
 * @property integer $origin_id
 * @property string $is_multi_spec
 * @property string $specification
 * @property string $price
 * @property integer $weight
 * @property integer $stock
 * @property string $is_cross_border
 * @property integer $sender_id
 * @property string $tax_rate
 * @property string $details
 * @property string $online
 * @property integer $online_scheduled
 * @property integer $created_at
 * @property string $created_by
 * @property integer $updated_at
 * @property string $updated_by
 *
 * @property ProductBrand $brand
 * @property ProductOrigin $origin
 * @property Sender $sender
 * @property ProductRecommend[] $productRecommends
 * @property ProductRecommend[] $productRecommends0
 * @property ProductRelCate[] $productRelCates
 * @property ProductCategory[] $categories
 */
class Product extends \yii\db\ActiveRecord {
	public $category_id;
	public $category_name;
	public $tag_id;
	public $tag_name;
	public $file;
	public $img_id;
	public $skey;
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'product';
	}
	
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [[['title','is_multi_spec','online','sender_id','tag_id','category_id'],'required'],
				[['title'],'string','max'=>60],
				[['is_multi_spec','is_cross_border','details','online'],'string'],
				[['price','tax_rate'],'number'],
				[['subtitle'],'string','max'=>255],
				[['sku','barcode'],'string','max'=>20],
				[['brand_id','origin_id','weight','stock','sender_id','online_scheduled','created_at','updated_at'],'integer'],
				[['specification','created_by','updated_by'],'string','max'=>45],
				[['brand_id'],'exist','skipOnError'=>true,'targetClass'=>ProductBrand::className (),'targetAttribute'=>['brand_id'=>'brand_id']],
				[['origin_id'],'exist','skipOnError'=>true,'targetClass'=>ProductOrigin::className (),'targetAttribute'=>['origin_id'=>'origin_id']],
				[['sender_id'],'exist','skipOnError'=>true,'targetClass'=>Sender::className (),'targetAttribute'=>['sender_id'=>'sender_id']],
				//新增
				[['specification','price','weight','stock','sku','barcode','tax_rate'],'required','when'=>function ($model) {return $model->is_multi_spec == 'N';},'whenClient'=>"function( attribute, value){ return $('#product-is_multi_spec').val() == 'N';}"],
				[['online_scheduled'],'required','when'=>function ($model) {return $model->online == 'N';},'whenClient'=>"function( attribute, value){ return $('#product-online').val() == 'N';}"],
				[['online_scheduled','created_at','updated_at'],'default','value'=>time()],
				];
	}
	
	// 数据保存前默认
// 	public function beforeSave($insert) {
// 		if (parent::beforeSave ( $insert )) {
// 			if ($this->isNewRecord) {
// 				$this->online_scheduled = time ();
// 				$this->created_at = time ();
// 				$this->updated_at = time ();
// 				$this->price = '0';
// 				$this->weight = '0';
// 				$this->tax_rate = '0';
// 				$this->stock = '0';
// 			}
// 			return true;
// 		} else
// 			return false;
// 	}
	
	/**
	 * 关联删除
	 * 
	 * @return bool
	 */
	public function beforeDelete() {
		if (parent::beforeDelete ()) {
			$ProductRelCate = new ProductRelCate ();
			$ProductRelCate->deleteAll ( 'product_id=:id', [':id'=>$this->product_id] );
			$ProductRelTag = new ProductRelTag ();
			$ProductRelTag->deleteAll ( 'product_id=:id', [':id'=>$this->product_id] );
			$ProductSpecification = new ProductSpecification ();
			$ProductSpecification->deleteAll ( 'product_id=:id', [':id'=>$this->product_id] );
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return ['product_id'=>'Product ID','title'=>'Title','subtitle'=>'Subtitle','sku'=>'Sku','barcode'=>'Barcode','brand_id'=>'Brand ID','origin_id'=>'Origin ID','is_multi_spec'=>'Is Multi Spec','specification'=>'Specification','price'=>'Price','weight'=>'Weight','stock'=>'Stock','is_cross_border'=>'Is Cross Border','sender_id'=>'Sender ID','tax_rate'=>'Tax Rate','details'=>'Details','online'=>'Online','online_scheduled'=>'Online Scheduled','created_at'=>'Created At','created_by'=>'Created By','updated_at'=>'Updated At','updated_by'=>'Updated By'];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getBrand() {
		return $this->hasOne ( ProductBrand::className (), ['brand_id'=>'brand_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrigin() {
		return $this->hasOne ( ProductOrigin::className (), ['origin_id'=>'origin_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getSender() {
		return $this->hasOne ( Sender::className (), ['sender_id'=>'sender_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProductRecommends() {
		return $this->hasMany ( ProductRecommend::className (), ['from_id'=>'product_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProductRecommends0() {
		return $this->hasMany ( ProductRecommend::className (), ['to_id'=>'product_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProductRelCates() {
		return $this->hasMany ( ProductRelCate::className (), ['product_id'=>'product_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategories() {
		return $this->hasMany( ProductCategory::className (), ['category_id'=>'category_id'] )->viaTable ( 'product_rel_cate', ['product_id'=>'product_id'] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getTags() {
		return $this->hasMany ( Tag::className (), ['tag_id'=>'tag_id'] )->viaTable ( 'product_rel_tag', ['product_id'=>'product_id'] );
	}
	
	public function getKeyword(){
		return $this->hasMany ( ProductKeyword::className(), ['product_id'=>'product_id'] );
	}
	
	public function getskey(){
		$arr = ArrayHelper::getColumn($this->getKeyword()->select('keyword')->asArray()->all(), 'keyword');
		$arr = implode('|',$arr);
		return $arr;
	}
	
	/**
	 * 商品规格下拉选取
	 * @param unknown $type
	 * @param string $ret
	 */
	public static function getSpecificationAll($type) {
		$LibSpecification = new LibSpecification ();
		
		$data = $LibSpecification->find ()->select ( 'name' )->where ( "type = '" . $type . "'" )->orderBy ( 'order desc' )->all ();
		
		return ArrayHelper::map ( $data, 'name', 'name' );
	}
	/**
	 * 商品品牌下拉选取
	 * @return \yii\db\ActiveRecord[]
	 */
	public static function getBrandAll() {
		$ProductBrand = new ProductBrand ();

		$data = $ProductBrand->find ()->select ( 'brand_id,name')->all ();
		return ArrayHelper::map ( $data, 'brand_id', 'name' );
	}
	/**
	 * 商品标签下拉选取
	 */
	public static function getTagAll() {
		$Tag = new Tag ();
		$data = $Tag->find ()->select ( 'tag_id,name' )->all ();
		return ArrayHelper::map ( $data, 'tag_id', 'name' );
	}
	/**
	 * 商品模式下拉选取
	 */
	public static function getSenderAll() {
		$Sender = new Sender ();
		
		$data = $Sender->find ()->select ( 'sender_id,name' )->orderBy ( 'order desc' )->all ();
		
		return ArrayHelper::map ( $data, 'sender_id', 'name' );
	}
	
	/**
	 * 商品原产国下拉选取
	 */
	public static function getOriginAll() {
		$ProductOrigin = new ProductOrigin ();
		$data = $ProductOrigin->find ()->select ( 'origin_id,name' )->all();

		return ArrayHelper::map ( $data, 'origin_id', 'name' );
	}
	
	/**
	 * 商品添加时，关联类别，标签
	 * @param unknown $product_id
	 * @param unknown $tag_id
	 * @param unknown $category_id
	 * @return boolean
	 */
	public function saveRelationId($tag_id,$model,$rel_id,$to_id,$type=FALSE) {
		if($type == true){
			Yii::$app->db->createCommand()->delete($model,['product_id'=>$rel_id])->execute();
		}
		foreach ($tag_id as $id){
			$rows[] = [
				'product_id'=> $rel_id,
				 $to_id => $id,
			];
		}
		Yii::$app->db->createCommand()->batchInsert($model, ['product_id', $to_id], $rows)->execute();
	}

}
