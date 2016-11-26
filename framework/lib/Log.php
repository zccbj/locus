<?php
namespace framework\lib;
class Log{
	/**
	 * 1确定日志存储方式.文件日志，或者是数据库日志
	 *2写日志
	 */
	static $class;
	static public function init(){
		$drive=Conf::get('DRIVE','log');
		self::$class=\framework\lib\Factory::getLog($drive);
		
	}
	static public function log($message,$file='log'){
//log给日志取个名
		self::$class->log($message,$file);
	}
}