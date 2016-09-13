<?php
namespace backend\components;

use Yii;
use Closure;
use yii\helpers\Html;


class ActionColumn extends \yii\grid\ActionColumn
{
	/**
	* auth和 buttons一样，都包含view update delete 3个元素，且都是回调函数
	* template 是第一层控制为完全是否显示，此为第二层是否有权限显示 
	* 这3个属性是可否操作，当不可操作的时候 会显示为灰色（详细见initDefaultButtons）
	*/
	
	public $auth=[];
    

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initDefaultAuth();
		$this->initDefaultButtons();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultAuth()
    {
        if (!isset($this->auth['view'])) {
            $this->auth['view'] = function ($url, $model, $key) {
                return true;
            };
        }
        if (!isset($this->auth['update'])) {
            $this->auth['update'] = function ($url, $model, $key) {
                return true;
            };
        }
        if (!isset($this->auth['delete'])) {
            $this->auth['delete'] = function ($url, $model, $key) {
               return true;
            };
        }
    }
	
	/**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
				$auth_class='';
				if(call_user_func($this->auth['view'], $url, $model, $key)!==true)
				{
					$url='javascript:void(0)';
					$auth_class='text-muted';
				}
                $options = array_merge([
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-eye-open '.$auth_class.'"></span>', $url, $options);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
				$auth_class='';
				if(call_user_func($this->auth['update'], $url, $model, $key)!==true)
				{
					$url='javascript:void(0)';
					$auth_class='text-muted';
				}
                $options = array_merge([
                    'title' => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-pencil gray-dark '.$auth_class.'"></span>', $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
				$auth_class='';
				if(call_user_func($this->auth['delete'], $url, $model, $key)!==true)
				{
					$url='javascript:void(0)';
					$auth_class='text-muted';
				}
                $options = array_merge([
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-trash '.$auth_class.'"></span>', $url, $options);
            };
        }
    }

 
}