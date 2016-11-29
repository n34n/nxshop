<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_keyword".
 *
 * @property integer $product_id
 * @property string $keyword
 */
class ProductKeyword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'keyword'], 'required'],
            [['product_id'], 'integer'],
            [['keyword'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'keyword' => Yii::t('app', 'Keyword'),
        ];
    }
}
