<?php
namespace common\components;

use yii;
use yii\web\UploadedFile;
use yii\imagine\Image;

class Upload extends UploadedFile
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
		return $this->file = UploadedFile::getInstance($model, $field);
	}
		
	
	/*
	 * save file
	 */
	public function saveFile($path,$filename='')
	{
		if ($this->file && $this->file->tempName) {
			if(!is_dir($this->rootpath.$path)){
				$this->makeDir($this->rootpath.$path);
			}
			
			if($filename == ''){
				$_file['name']	= md5($path.time());
			}else{
				$_file['name']	= $filename;
			}
			
			$_file['ext']		= $this->file->extension;
			$_file['path']		= $path;
			$_file['savepath']	= $this->rootpath.$path;
			$_file['file']		= $_file['name'].'.'.$_file['ext'];			
			
			$this->file->saveAs($_file['savepath'].$_file['file']);
			return $_file;
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
			$size['w'] = $size['h'] = $data[0];
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