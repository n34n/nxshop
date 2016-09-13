<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $related_id
 * @property string $path_l
 * @property string $path_m
 * @property string $path_s
 * @property integer $created_at
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'related_id'], 'required'],
            [['related_id', 'created_at'], 'integer'],
            [['model'], 'string', 'max' => 50],
            [['path_l', 'path_m', 'path_s'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => '模块名',
            'related_id' => '关联id',
            'path_l' => '大图存放地址',
            'path_m' => '中图存放地址',
            'path_s' => '小图图存放地址',
            'created_at' => 'Created At',
        ];
    }
}
