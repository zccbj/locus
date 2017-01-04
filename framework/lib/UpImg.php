<?php
namespace framework\lib;
class UpImg{
    public $name;
    public $type;
    public $tmp_name;
    public $error;
    public $size;

    public $saveName;
    public $postFix;
    public $savaPath;

    public $ph_type=array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');    //允许上传图片类型
    public $ph_size=1000000;   //允许上传文件大小


    public function __construct($arr=NULL){
      if (!empty($arr)) {
        foreach ($arr as $key => $value) {
        $this->$key=$value;
        }
      }
      $this->isSize();
      $this->setSaveName();
      $this->setPostFix();
      $this->setSavePath();
    }

    public function setSaveName(){
        $this->saveName=uniqid();

    }
    public function setPostFix(){
        if (in_array($this->type, $this->ph_type)) {

            $a=explode('/',$this->type);
            $this->postFix='.'.$a[1];
        }

    }
    public function setSavePath(){
        $this->savaPath='/tupian/'.date('Ymd').'/';
    }
    public function isSize(){
        if ($this->size > $this->ph_size) {
            exit();
        }
    }

}
