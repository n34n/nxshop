<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $product_id
 * @property integer $spec_id
 * @property string $sku
 * @property string $product_name
 * @property string $unit_price
 * @property integer $unit_weight
 * @property string $tax_rate
 * @property integer $quantity
 * @property string $subtotal_price
 * @property integer $subtotal_weight
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'product_id', 'product_name'], 'required'],
            [['product_id', 'spec_id', 'unit_weight', 'quantity', 'subtotal_weight'], 'integer'],
            [['unit_price', 'tax_rate', 'subtotal_price'], 'number'],
            [['order_sn', 'sku'], 'string', 'max' => 20],
            [['product_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'Id'),
            'order_sn' => Yii::t('backend', 'Order Sn'),
            'product_id' => Yii::t('menu', 'Product').Yii::t('backend', 'Id'),
            'spec_id' => Yii::t('menu', 'Specification').Yii::t('backend', 'Id'),
            'sku' => Yii::t('backend', 'Sku'),
            'product_name' => Yii::t('menu', 'Product').Yii::t('backend', 'Name'),
            'unit_price' => Yii::t('backend', 'Unit').Yii::t('backend', 'Price'),
            'unit_weight' => Yii::t('backend', 'Unit').Yii::t('backend', 'Weight'),
            'tax_rate' => Yii::t('backend', 'Tax_rate'),
            'quantity' => Yii::t('backend', 'Quantity'),
            'subtotal_price' => Yii::t('backend', 'Subtotal').Yii::t('backend', 'Price'),
            'subtotal_weight' => Yii::t('backend', 'Subtotal').Yii::t('backend', 'Weight'),
        ];
    }
}
