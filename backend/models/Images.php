<?php

namespace backend\models;

use Yii;
use common\components\Upload;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property integer $id
 * @property string $model
 * @property string $file
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
            [['model', 'file'], 'string', 'max' => 50],
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
            'model' => 'Model',
            'file' => 'File',
            'related_id' => 'Related ID',
            'path_l' => 'Path L',
            'path_m' => 'Path M',
            'path_s' => 'Path S',
            'created_at' => 'Created At',
        ];
    }
    
    public function deleteimg($id)
    {
    	$model = $this->findModel($id);
    	Upload::deleteImg($model->path_l);
    	Upload::deleteImg($model->path_m);
    	Upload::deleteImg($model->path_s);
    	echo json_encode("succ");
    }    
}
