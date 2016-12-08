<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property string $order_type
 * @property integer $member_id
 * @property integer $stage
 * @property integer $status
 * @property string $consignee
 * @property string $mobile
 * @property string $telphone
 * @property string $idcard
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $buyer
 * @property string $buyer_mobile
 * @property string $buyer_idcard
 * @property string $invoice
 * @property string $invoice_title
 * @property integer $order_weight
 * @property integer $order_quantity
 * @property string $currency
 * @property string $product_amount
 * @property string $shipping_fee
 * @property string $tax
 * @property string $save
 * @property string $order_amount
 * @property string $order_sn
 * @property integer $created_at
 * @property string $pay_method
 * @property string $pay_sn
 * @property integer $pay_at
 * @property string $express_com
 * @property string $express_sn
 * @property integer $express_at
 * @property integer $confirm_at
 * @property integer $express_csi
 * @property integer $service_csi
 *
 * @property LibCurrency $currency0
 */
class Order extends \yii\db\ActiveRecord
{
	public $product_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['member_id','consignee'], 'required'],
            [['order_type', 'invoice'], 'string'],
            [['member_id', 'stage', 'status', 'order_weight', 'order_quantity', 'created_at', 'pay_at', 'express_at', 'confirm_at', 'express_csi', 'service_csi'], 'integer'],
            [['product_amount', 'shipping_fee', 'tax', 'save', 'order_amount'], 'number'],
            [['consignee', 'buyer'], 'string', 'max' => 10],
            [['mobile', 'buyer_mobile'], 'string', 'max' => 11],
            [['telphone', 'province', 'city', 'area', 'order_sn', 'pay_method', 'express_com', 'express_sn'], 'string', 'max' => 20],
            [['idcard', 'buyer_idcard'], 'string', 'max' => 18],
            [['address'], 'string', 'max' => 60],
            [['invoice_title'], 'string', 'max' => 45],
            [['currency'], 'string', 'max' => 3],
            [['pay_sn'], 'string', 'max' => 32],
            [['order_sn'], 'unique'],
            [['pay_sn'], 'unique'],
            [['express_sn'], 'unique'],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => LibCurrency::className(), 'targetAttribute' => ['currency' => 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('backend', 'Order Id'),
            'order_type' => Yii::t('backend', 'Order Type'),
            'member_id' => Yii::t('backend', 'User'),
//         		0 订单取消
//         		1 支付阶段
//         		2 发货阶段
//         		3 收货阶段
//         		4 评价阶段
//         		5 完成阶段
        	'stage' => Yii::t('backend', 'Stage'),    
//         		0 删除状态 (仅成交订单)
//         		1 支付阶段
//         		－10 未支付
//         		－11 已支付
//         		－12 取消订单
//         		2 发货阶段
//         		－20 已发货
//         		3 收货阶段
//         		－30 已收货 (成交)
//         		4 评价阶段
//         		－40 部分评价
//         		－41 评价完成
            'status' => Yii::t('backend', 'Order Status'),
            'consignee' => Yii::t('backend', 'Consignee'),
            'mobile' => Yii::t('backend', 'Consignee').Yii::t('backend', 'Mobile'),
            'telphone' => Yii::t('backend', 'Consignee').Yii::t('backend', 'Telphone'),
            'idcard' => Yii::t('backend', 'Consignee').Yii::t('backend', 'Idcard'),
            'province' => Yii::t('backend', 'Province'),
            'city' => Yii::t('backend', 'City'),
            'area' => Yii::t('backend', 'Area'),
            'address' => Yii::t('backend', 'Address'),
            'buyer' => Yii::t('backend', 'Buyer'),
            'buyer_mobile' => Yii::t('backend', 'Buyer').Yii::t('backend', 'Mobile'),
            'buyer_idcard' => Yii::t('backend', 'Buyer').Yii::t('backend', 'Idcard'),
            'invoice' => Yii::t('backend', 'Invoice'),
            'invoice_title' => Yii::t('backend', 'Invoice Title'),
            'order_weight' => Yii::t('backend', 'Order Weight'),
            'order_quantity' => Yii::t('backend', 'Order Quantity'),
            'currency' => Yii::t('backend', 'Currency'),
            'product_amount' => Yii::t('backend', 'Product Amount'),
            'shipping_fee' => Yii::t('backend', 'Shipping Fee'),
            'tax' => Yii::t('backend', 'Tax'),
            'save' => Yii::t('backend', 'Save'),
            'order_amount' => Yii::t('backend', 'Order Amount'),
            'order_sn' => Yii::t('backend', 'Order Sn'),
            'created_at' => Yii::t('backend', 'Created at'),
            'pay_method' => Yii::t('backend', 'Pay Method'),
            'pay_sn' => Yii::t('backend', 'Pay Sn'),
            'pay_at' => Yii::t('backend', 'Pay At'),
            'express_com' => Yii::t('backend', 'Express Com'),
            'express_sn' => Yii::t('backend', 'Express Sn'),
            'express_at' => Yii::t('backend', 'Express At'),
            'confirm_at' => Yii::t('backend', 'Confirm At'),
            
//         		1 不满意
//         		3 一般
//         		5 满意
        	'express_csi' => Yii::t('backend', 'Express Csi'),
//         		1 不满意
//         		3 一般
//         		5 满意
            'service_csi' => Yii::t('backend', 'Service Csi'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(LibCurrency::className(), ['code' => 'currency']);
    }
}
