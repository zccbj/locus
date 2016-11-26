<?php
namespace framework\lib;
class Register{
	//注册数模式，把对象都放在这，统一可以用
	protected static $objects;
	static function set($key,$object){
		self::$objects[$key]=$object;
		//var_dump(self::$objects[$key]);
	}	
	static function get($key){
		return self::$objects[$key];
	}
	static function _unset($key){
		unset(self::$objects[$key]);

	}

}