<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $icon
 */
class Language extends \yii\db\ActiveRecord
{
	public $filename;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language'], 'required'],
            [['language'], 'unique'],
            [['language'], 'string', 'max' => 20],
            [['code'], 'required'],
            [['code'], 'unique'],
            [['code'], 'string', 'max' => 4],
            [['icon'], 'file', 'extensions' => ['png', 'jpg', 'gif']],
            [['order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }
}
