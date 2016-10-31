<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lib_specification".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $order
 */
class LibSpecification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lib_specification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['type'], 'string'],
            [['order'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'order' => 'Order',
        ];
    }
}
