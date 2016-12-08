<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $city_id
 * @property string $city_name
 * @property integer $pid
 * @property string $post_code
 * @property integer $code
 * @property string $path
 * @property string $level
 * @property integer $order
 * @property string $disabled
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_name', 'code'], 'required'],
            [['pid', 'code', 'level', 'order'], 'integer'],
            [['disabled'], 'string'],
            [['city_name'], 'string', 'max' => 50],
            [['post_code'], 'string', 'max' => 10],
            [['path'], 'string', 'max' => 20],
            [['pid', 'level', 'city_name'], 'unique', 'targetAttribute' => ['pid', 'level', 'city_name'], 'message' => 'The combination of 地区名称, 上一级地区的序号 and 地区层级 has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => Yii::t('backend', 'Id'),
            'city_name' => Yii::t('backend', 'City Name'),
            'pid' => Yii::t('backend', 'Parent'),
            'post_code' => Yii::t('backend', 'Post Code'),
            'code' => Yii::t('backend', 'Area Code'),
            'level' => Yii::t('backend', 'Level'),
            'order' => Yii::t('backend', 'Order'),
            'disabled' => Yii::t('backend', 'Disabled'),
        ];
    }
    
    public static function getCityAll($parentId = 0, $array = [], $level = 0, $add = 2, $repeat = '　 '){
    	$strRepeat = '';
    	if ($level > 1) {
    		for ($j = 0; $j < $level; $j++) {
    			$strRepeat .= $repeat;
    		}
    	}
    	$newArray = array ();
    	foreach ((array)$array as $v) {
    		if ($v['pid'] == $parentId) {
    			$item = (array)$v;
    			$item['label'] = $strRepeat . (isset($v['city_name']) ? $v['city_name'] : $v['city_name']);
    			$newArray[] = $item;
    	
    			$tempArray = self::getCityAll($v['city_id'], $array, ($level + $add), $add, $repeat);
    			if ($tempArray) {
    				$newArray = array_merge($newArray, $tempArray);
    			}
    		}
    	}
    	return $newArray;
    }
    
}
