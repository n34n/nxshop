<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user_log}}".
 *
 * @property string $id
 * @property string $username
 * @property string $action
 * @property string $url
 * @property string $ip
 * @property string $agent
 * @property string $get
 * @property string $post
 * @property integer $log_time
 */
class UserLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'action', 'get', 'post', 'log_time'], 'required'],
            [['get', 'post'], 'string'],
            [['log_time'], 'integer'],
            [['username', 'ip'], 'string', 'max' => 50],
            [['action', 'agent'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
        ];
    }

}
