<?php
namespace framework;
class Framework{
	public static function run(){
		Framework::initPath();
		Framework::loadConfig();
		spl_autoload_register('framework\Framework::autoloader');
		Framework::dispatch();
	}
	private static function initPath(){
		define('DS', DIRECTORY_SEPARATOR);//分隔符
		define('ROOT_DIR',realpath('.').DS);//绝对路径。执行位置的绝对路径
		define('FRAME_DIR',ROOT_DIR.'framework'.DS);
		define('APP_DIR',ROOT_DIR.'app'.DS);
		define('LOG_DIR',ROOT_DIR.'log'.DS);
		define('CTRL_DIR',APP_DIR.'controller'.DS);
		define('VIEW_DIR',APP_DIR.'view'.DS);
		define('MODEL_DIR',APP_DIR.'model'.DS);
		define('RUNTIME_DIR',APP_DIR.'runtime'.DS);
		define('TOOL_DIR',FRAME_DIR.'tool'.DS);
		define('LIB_DIR',FRAME_DIR.'lib'.DS);
		define('CONFIG_DIR',FRAME_DIR.'config'.DS);

	}
	private static function loadConfig(){
		$GLOBALS['config'] = require CONFIG_DIR.'app.php';
		ini_set('date.timezone',$GLOBALS['config']['TIMEZONE']);
		if($GLOBALS['config']['DEBUG']){
			ini_set('display_errors', true);

		}else{
			ini_set('display_errors', false);
		}
	}
	public static function autoloader($class){
		$class=str_replace('\\', DS, $class);
		$class=ROOT_DIR.$class.'.php';
		include $class;
	}

	private static function dispatch(){
		$route=new lib\Route();//不加\说明是相对路径下的，相对于当前命名空间.加了\则表示绝对路径
		$ctrl=$route->ctrl;
		$action=$route->action.'Action';
		$ctrlClass='\app\\controller\\'.$ctrl.'Controller';
		$ctrlFile=CTRL_DIR.$ctrl.'Controller.php';

		//lib\Log::init();//日志
		if (is_file($ctrlFile)) {
			$ctrl=new $ctrlClass;
			$ctrl->$action();

			//lib\Log::log($ctrlClass.'|'.$action,'enter');//日志
		}else{
			// throw new Exception("Error Not File:".$ctrlFile);
			echo 'Error Not File:'.$ctrlFile;
			
		}
	}

	
	
}