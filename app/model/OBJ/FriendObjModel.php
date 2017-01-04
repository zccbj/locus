<?php
namespace app\model\OBJ;
class FriendObjModel{
		//鼠标选中多行，按下 Ctrl Shift L (Command Shift L) 即可同时编辑这些行；
	private $friendId;
	private $masterId;
	private $userId;
	private $friendType;


	public function __set($key,$value){
		$this->$key=$value;
	}
	public function __get($key){
		if (isset($this->$key)) {
			return $this->$key;
		}
		return NULL;
	}	
	public function __construct($arr=NULL){
		if (!empty($arr)) {
			foreach ($arr as $key => $value) {
			$this->$key=$value;
			}
		}
	}
	public function ObjToArr() {	  
	    foreach ($this as $key => $value) {
	      $array[$key] = $value;
	    }

	  return $array;
	}
}