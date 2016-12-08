<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lib_currency".
 *
 * @property string $code
 * @property string $name
 * @property string $sign
 *
 * @property Order[] $orders
 */
class LibCurrency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lib_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'sign'], 'required'],
            [['code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 20],
            [['sign'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'sign' => Yii::t('app', 'Sign'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['currency' => 'code']);
    }
}
