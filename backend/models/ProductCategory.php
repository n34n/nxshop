<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_category".
 * 
 * @property integer $category_id
 * @property string $name
 * @property integer $pid
 * @property integer $level
 * @property integer $order
 * @property string $disabled
 *
 * @property ProductRelCate[] $productRelCates
 * @property Product[] $products
 */
class ProductCategory extends \yii\db\ActiveRecord {
	public $filename;
	public $file;
	public $img_id;
	public $id;
	public $path_s;
	
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'product_category';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'name' 
						],'required' 
				],[ 
						[ 
								'pid','level','order' 
						],'integer' 
				],[ 
						[ 
								'disabled' 
						],'string' 
				],[ 
						[ 
								'name','path' 
						],'string','max' => 20 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'category_id' => 'Category ID','name' => 'Name','pid' => 'Pid','level' => 'Level','path' => 'Path','order' => 'Order','disabled' => 'Disabled' 
		];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProductRelCates() {
		return $this->hasMany ( ProductRelCate::className (), [ 
				'category_id' => 'category_id' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getProducts() {
		return $this->hasMany ( Product::className (), [ 
				'product_id' => 'product_id' 
		] )->viaTable ( 'product_rel_cate', [ 
				'category_id' => 'category_id' 
		] );
	}
	public function getImages() {
		/**
		 * 第一个参数为要关联的字表模型类名称，
		 * 第二个参数指定 通过子表的 id 去关联主表的 id 字段
		 */
		return $this->hasOne ( Images::className (), [ 
				'related_id' => 'category_id' 
		] )->onCondition ( [ 
				'images.model' => 'product-category' 
		] );
	}
	
	/**
	 * 页面加载商品层级分类
	 */
	public function setCategoryList() {
		$data = $this->getCategoryList ();
		
		foreach ( $data as $_menu ) {
			echo "<tr class='bg-gray disabled color-palette'>";
			echo "<td>" . $_menu ['name'] . "</td>";
			echo '<td style="text-align:right;">
    		      	<a data-pjax="0" title="新增" href="index.php?r=product-category/index"><span class="glyphicon glyphicon-plus-sign"></span></a>
    		      	<a data-pjax="0" title="修改" href="index.php?r=product-category/index&id=' . $_menu ['category_id'] . '"><span class="glyphicon glyphicon-pencil"></span></a>
    		      	<a data-pjax="0" data-confirm="确定要删除该记录吗？" title="删除" href="index.php?r=product-category/delete&id=' . $_menu ['category_id'] . '"><span class="glyphicon glyphicon-trash"></span></a>
    		      </td>';
			echo "</tr>";
			
			if (isset ( $_menu ['data'] )) {
				foreach ( $_menu ['data'] as $_submenu ) {
					echo "<tr >";
					echo "<td style='padding-left:40px'>" . $_submenu ['name'] . "</td>";
					echo '<td style="text-align:right;">
							<a data-pjax="0" title="新增" href="index.php?r=product-category/index"><span class="glyphicon glyphicon-plus-sign"></span></a>
							<a data-pjax="0" title="修改" href="index.php?r=product-category/index&id=' . $_submenu ['category_id'] . '"><span class="glyphicon glyphicon-pencil"></span></a>
							<a data-pjax="0" data-confirm="确定要删除该记录吗？" title="删除" href="index.php?r=product-category/delete&id=' . $_submenu ['category_id'] . '"><span class="glyphicon glyphicon-trash"></span></a>
						  </td>';
					echo "</tr>";
					if (isset ( $_submenu ['data'] )) {
						foreach ( $_submenu ['data'] as $submenu ) {
							echo "<tr>";
							echo "<td style='padding-left:80px'>" . $submenu ['name'] . "</td>";
							echo '<td style="text-align:right;">
									<a data-pjax="0" title="修改" href="index.php?r=product-category/index&id=' . $submenu ['category_id'] . '"><span class="glyphicon glyphicon-pencil"></span></a>
									<a data-pjax="0" data-confirm="确定要删除该记录吗？" title="删除" href="index.php?r=product-category/delete&id=' . $submenu ['category_id'] . '"><span class="glyphicon glyphicon-trash"></span></a>
						  		  </td>';
							echo "</tr>";
						}
					}
				}
			}
		}
		;
	}
	private function getCategoryList() {
		$list_level_1 = $this->find ()->orderBy ( 'level' )->all ();
		$list_level_1 = ArrayHelper::toArray ( $list_level_1 );
		$category_array = array ();
		foreach ( $list_level_1 as $list ) {
			$id = $list ['category_id'];
			$key = explode ( ',', $list ['path'] );
			switch ($list ['level']) {
				case 1 :
					$category_array [$key [0]] = $list;
					break;
				case 2 :
					$category_array [$key [0]] ['data'] [$key [1]] = $list;
					break;
				case 3 :
					$category_array [$key [0]] ['data'] [$key [1]] ['data'] [$key [2]] = $list;
					break;
			}
		}
		return $category_array;
	}
	
	/**
	 * 新增或更改时，更新path
	 * 
	 * @param unknown $id
	 * @param unknown $level
	 * @return string
	 */
	public function savepath($id, $level) {
		$arr = Yii::$app->request->post ();
		$pid = $arr ['ProductCategory'] ['pid'];
		// $level = $arr['ProductCategory']['level'];
		
		switch ($level) {
			case 1 :
				$path = $id;
				break;
			case 2 :
				$path = $pid . ',' . $id;
				break;
			case 3 :
				$_pid = $this->find ()->select ( [ 
						'pid' 
				] )->where ( [ 
						'category_id' => $pid 
				] )->one ();
				$_pid = ArrayHelper::toArray ( $_pid );
				$path = $_pid ['pid'] . ',' . $pid . ',' . $id;
				break;
		}
		$this->updateAll ( [ 
				'path' => $path 
		], "category_id=:id", [ 
				'id' => $id 
		] );
		return $path;
	}
	
	/**
	 * 加载下拉层级菜单
	 * 
	 * @param unknown $pid
	 */
	public function dropDownList($pid = null) {
		$model = new ProductCategory ();
		
		$dropDownList = $model->find ()->where ( "level != 3" )->orderBy ( 'order,level DESC' )->all ();
		
		foreach ( $dropDownList as $k => $v ) {
			if ($v ['level'] == 1) {
				echo '<option   value=' . $v ['category_id'] . '>' . $v ['name'] . '</option>';
			} else {
				echo "<option  value=" . $v ['category_id'] . ">&nbsp&nbsp&nbsp&nbsp" . $v ['name'] . "</option>";
			}
		}
	}
	
	/**
	 * 页面加载获取，下拉层级菜单(js)根据pid选中
	 * 
	 * @return \yii\db\ActiveRecord|NULL
	 */
	public static function getpid() {
		$data = [ ];
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$model = new ProductCategory ();
			
			$data = $model->find ( [ 
					'pid' 
			] )->where ( [ 
					'category_id' => $_GET ['id'] 
			] )->one ();
		}
		return $data;
	}
}
