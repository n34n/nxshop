<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_rel_tag".
 *
 * @property integer $tag_id
 * @property integer $product_id
 */
class ProductRelTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_rel_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'product_id'], 'required'],
            [['tag_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'product_id' => 'Product ID',
        ];
    }
}
