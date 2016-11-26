<?php
namespace framework\lib;
class Factory{
	//用工厂模式
	static function getCache($key){
		//注册器模式
		@$cache = Register::get($key);
		if(!$cache){
			$cache = new Cache();
			Register::set($key,$cache);
		}
		return $cache;
	} 
	static function getLog($key){
		//注册器模式
		@$log = Register::get($key);
		if(!$log){
			$class='\framework\lib\drive\log\\'.$key;
			$log=new $class;
			Register::set($key,$log);
		}
		return $log;
	}
	static function getObj($key){
		//注册器模式
		@$obj = Register::get($key);
		if(!$obj){
			$class= '\app\model\OBJ\\'.$key.'ObjModel';
			$obj=new $class;
			Register::set($key,$obj);
		}
		
		return clone $obj;
	}
}