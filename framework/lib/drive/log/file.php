<?php
namespace framework\lib\drive\log;
use framework\lib\conf;
class file{
	 public $path;
	public function __construct(){
		$conf=conf::get('OPTION','log');
		$this->path=$conf['PATH'];
	}
	public function log($message,$file='log'){
		
		/*
		 * 1确定文件存储位置是否存在
		 *	新建目录
		 *2写入日志
		*/ 

		if (!file_exists($this->path.date('YmdH'))) {//is_file($file)file_exists($file)当$file是目录时，is_file返回false，file_exists返回true
			// echo('arg1');
			mkdir($this->path.date('YmdH'),0777,true);
		}
		return file_put_contents($this->path.date('YmdH').'/'.$file.'.php', date('Y-m-d H-i-s').json_encode($message).PHP_EOL,FILE_APPEND);
	}
}