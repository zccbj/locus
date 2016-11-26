<?php
namespace framework\lib;
class Conf{
	static public $conf=array();
	static public function get($name,$file){
		/**用于读取配置文件。返回配置文件数组中的一个配置
		 *1判断配置文件是否存在
		 *2判断配置是否存在
		 *3缓存配置
		 */
		if(isset(self::$conf[$file])){

			return self::$conf[$file][$name];
		}else{
			$path=CONFIG_DIR.$file.'.php';
			if (is_file($path)) {
				$conf=include $path;
				if (isset($conf[$name])) {
					self::$conf[$file]=$conf;
					return $conf[$name];
				}else{
					throw new Exception("找不到配置".$name);
				
				}

			}else{
				throw new Exception("找不到配置文件".$file);
			
			}
		}

		
	}
	static public function all($file){
		/**返回配置文件数组中的所有配置
		 * 1判断配置文件是否存在
		 *2判断配置是否存在
		 *3缓存配置
		 */
		if(isset(self::$conf[$file])){
			return self::$conf[$file];
		}else{

			$path=CONFIG_DIR.$file.'.php';
			if (is_file($path)) {
				$conf=include $path;
				self::$conf[$file]=$conf;

				return $conf;
				
			}else{
				throw new Exception("找不到配置文件".$file);
			
			}
		}
		
	 }

}