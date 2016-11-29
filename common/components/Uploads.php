<?php
namespace common\components;

use yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use backend\models\Images;

class Uploads extends UploadedFile
{
    public $rootpath;
    public $file;
    
	/*
	 * init
	 */
	public function __construct($uploadpath='@uploads'){
		$this->rootpath = Yii::getAlias($uploadpath).'/';
	}
	
	
	/*
	 * create instance
	 */
	public function createInstance($model, $field)
	{
		return $this->file = UploadedFile::getInstances($model, $field);
	}
		
	
	/*
	 * save file
	 */
	public function saveFile($path,$related_id,$model,$filename='')
	{
		if ($this->file) {
			for ($i=0;$i<count($this->file);$i++){
				if(!is_dir($this->rootpath.$path.$i)){
					$this->makeDir($this->rootpath.$path.$i);
				}
				if($filename == ''){
					$_file['name']	= md5($path.time());
				}else{
					$_file['name']	= $filename;
				}
				$_file['ext']		= $this->file[$i]->extension;
				$_file['path']		= $path.$i.'/';
				$_file['savepath']	= $this->rootpath.$path.$i.'/';
				$_file['file']		= $_file['name'].'.'.$_file['ext'];

				$this->file[$i]->saveAs($_file['savepath'].$_file['file']);
				
				$path_l = $_file ['path'] . $_file ['file'];
				$path_m = $this->thumb ( $_file, '_m', 300, 300 );
				$path_s = $this->thumb ( $_file, '_s', 30, 30 );
					
				// db save image
				$img = new Images ();
				$img->model = $model;
				$img->related_id = $related_id;
				$img->path_l = $path_l;
				$img->path_m = $path_m;
				$img->path_s = $path_s;
				$img->created_at = time ();
				$img->save ();
			}
		}
	}
	
	
	/*
	 * make thumbnail 
	 */
	public function thumb($file,$tag,$width,$height,$quality=100)
	{
		$src_file	= $file['savepath'].$file['file'];
		$save_file	= $file['savepath'].$file['name'].$tag.'.'.$file['ext'];
		$dbpath	= $file['path'].$file['name'].$tag.'.'.$file['ext'];
		
		
		$data = getimagesize($src_file);
		if($data[0] == $data[1]){
			$size['w'] = $size['h'] = $width;
		}else{
			$size = $this->getSize($data,$width,$height);
		}
		
		Image::thumbnail($src_file,$size['w'],$size['h'])
		->save(Yii::getAlias($save_file), ['quality' => $quality]);
		return $dbpath;
	}
	
	
	/*
	 * calculate image width/height
	 */
	public function getSize($data,$width,$height)
	{
		$_width 	= $data[0];
		$_height	= $data[1];
		
		if($_width > $_height){
			$w = $width;
			$h = $_height/$_width*$w;
		}else{
			$h = $height;
			$w = $_width/$_height*$h;
		}
		
		$size['w'] = (int)$w;
		$size['h'] = (int)$h;
		
		return $size;
	}
	
	
	/*
	 * generate folder
	 */
	public function makeDir($path)
	{
		if (!file_exists($path)){
			$this->makeDir(dirname($path));
			mkdir($path, 0777);
		}
	}
	
	
	/*
	 * remove file
	 */
	public function delFile($file)
	{
		$file = $this->rootpath.$file;
		if($file!='' && file_exists($file) && !is_dir($file)){
			unlink($file);
		}
	}
	
}