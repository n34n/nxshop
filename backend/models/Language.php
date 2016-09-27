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
	public $file;
	public $path_s;
	public $img_id;
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
    
    public function getImages()
    {
        /**
         * 第一个参数为要关联的字表模型类名称，
         * 第二个参数指定 通过子表的 id 去关联主表的 id 字段
         */
        return $this->hasOne(Images::className(), ['related_id' => 'id'])->onCondition(['images.model' => 'language']);
    }  
}
