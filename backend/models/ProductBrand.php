<?php

namespace backend\models;


use Yii;

/**
 * This is the model class for table "product_brand".
 *
 * @property integer $brand_id
 * @property string $name
 * @property integer $order
 * @property string $disabled
 *
 * @property Product[] $products
 */
class ProductBrand extends \yii\db\ActiveRecord
{
	public $filename;
	public $file;
	public $img_id;
	public $id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order'], 'integer'],
            [['disabled'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => 'Brand ID',
            'name' => 'Name',
            'order' => 'Order',
            'disabled' => 'Disabled',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['brand_id' => 'brand_id']);
    }
}
