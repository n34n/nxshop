<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "comment".
 *
 * @property integer $comment_id
 * @property integer $reply_id
 * @property integer $member_id
 * @property integer $product_id
 * @property string $hidden_name
 * @property string $comment
 * @property integer $created_at
 * @property string $created_by
 * @property integer $checked_at
 * @property string $checked_by
 * @property string $display
 * @property integer $csi
 */
class ProductComment extends \yii\db\ActiveRecord
{
	public $filename;
	public $file;
	public $img_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reply_id', 'member_id', 'product_id', 'created_at', 'checked_at', 'csi'], 'integer'],
            [['product_id'], 'required'],
            [['display'], 'string'],
            [['hidden_name', 'created_by', 'checked_by'], 'string', 'max' => 45],
            [['comment'], 'string', 'max' => 255],
        	//默认项
        	[['member_id'],'default','value'=>yii::$app->user->id],
        	[['reply_id'],'default','value'=>'0'],
        	[['comment'],'default','value'=>'Very good'],
        	[['created_at','checked_at'],'default','value'=>time()],
        	[['display'],'default','value'=>'N'],
        	[['csi'],'default','value'=>'5'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'reply_id' => 'Reply ID',
            'member_id' => 'Member ID',
            'product_id' => 'Product ID',
            'hidden_name' => 'Hidden Name',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'checked_at' => 'Checked At',
            'checked_by' => 'Checked By',
            'display' => 'Display',
            'csi' => 'Csi',
        ];
    }

    public static function getProduct(){
    	$data = Product::find()->select(['product_id','title'])->all();
    	return ArrayHelper::map($data, 'product_id', 'title');
    }
    
}
