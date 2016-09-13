<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;
use Yii;
//use yii\log\DbTarget;
use yii\db\Connection;
use yii\base\InvalidConfigException;
use yii\di\Instance;
//use yii\helpers\VarDumper;


class DbTarget extends \yii\log\DbTarget
{
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     * After the DbTarget object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';
    /**
     * @var string name of the DB table to store cache content. Defaults to "log".
     */
    public $logTable = '{{%user_log}}';


    /**
     * Initializes the DbTarget component.
     * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
     * @throws InvalidConfigException if [[db]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    /**
     * Stores log messages to DB.
     */
/*      public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[message]])
                VALUES (:level, :category, :log_time, :prefix, :message)";
        $command = $this->db->createCommand($sql);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
             if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Throwable || $text instanceof \Exception) {
                    $text = (string) $text;
                } else {
                    $text = VarDumper::export($text);
                }
            } 
            $command->bindValues([
                ':level' => $level,
                ':category' => 'hello',//$category,
                ':log_time' => $timestamp,
                ':prefix' => $this->getMessagePrefix($message),
                ':message' => $text,
            ])->execute();
        }
    }  */
    
    
     public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[username]], [[action]], [[url]], [[ip]], [[agent]], [[get]], [[post]], [[log_time]])
        VALUES (:username, :action, :url, :ip, :agent, :get, :post, :log_time)";
        $command = $this->db->createCommand($sql);

        //list($text, $level, $category, $timestamp) = $this->messages;
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            $command->bindValues([
                ':username' => Yii::$app->user->identity['username'],
                ':action' => $message,
                ':url' => Yii::$app->request->absoluteUrl,
                ':ip' => Yii::$app->request->userIP,
                ':agent' => Yii::$app->request->headers->get('User-Agent'),
                ':get' => json_encode(Yii::$app->request->get()),//Yii::$app->controller->id,
                ':post' => json_encode(Yii::$app->request->post()),//Yii::$app->controller->action->id,
                ':log_time' => time(),
            ])->execute();die();            
        } 
         
    }     
    
}
