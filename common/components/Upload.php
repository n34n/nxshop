<?php
namespace common\components;

use yii;
use yii\web\UploadedFile;

class Upload extends UploadedFile
{
    //public $upload_path = '@uploads';
       
    /*
     * upload file
     * */
    public static function uploadImg($model,$field,$filepath,$action='create',$filename='')
    {
        $file = UploadedFile::getInstance($model, $field);        
        if ($file && $file->tempName) {
            if($action == 'update'){
                Upload::deleteImg($filename);
            }
            $rootpath = Yii::getAlias('@uploads').'/';
            $filename = $model->code.'.'. $file->extension;
            $uploadfile = $rootpath.$filepath.$filename;
            $file->saveAs($uploadfile);
            return $filepath.$filename;
        }else{
            return $filename;
        }
    }
    
    /*
     * delete file
     * */
    public static function deleteImg($filename)
    {
        if($filename!=''){
            $path = Yii::getAlias('@uploads').'/';
            $filename = $path.$filename;
            if(file_exists($filename)){
                unlink($filename);
            }
        }
    }
}