<?php
namespace framework\lib;
class Cache{
	// 可以写一个注册器方法
	public $dir;
	public $ext;
	public function __construct(){
		$conf=conf::all('cache');
		$this->dir=$conf['OPTION']['PATH'];
		$this->ext=$conf['ext'];
	}
	//cacheData('name','123');设置
	//cacheData('name',null);删除
	//cacheData('name');获取
	public function cacheData($key,$value='',$cacheTime=0){

		 $filename=$this->dir.$key.$this->ext;

		if ($value!=='') {
			if (is_null($value)) {
				//value==null,删除缓存
				return @unlink($filename);
			}
			//value,添加缓存
			$dir=dirname($filename);//函数返回路径中的目录部分。
			 if (!is_dir($dir)) {//创建目录
			 	mkdir($dir,0777);
			 }
			$cacheTime=sprintf('%011d',$cacheTime);
			return file_put_contents($filename, $cacheTime.json_encode($value));//第二个参数只能为字符串	
		}

		//value=='',获取缓存
		if(!is_file($filename)){
			return false;

		}else{
			$contents=file_get_contents($filename);
			$cacheTime=(int)substr($contents, 0,11);
			$value=substr($contents, 11);
			if (($cacheTime!=0)&&($cacheTime+filemtime($filename))<time()) {//设置的时间＋文件创建时间<现在时间
				//filemtime() 函数返回文件内容上次的修改时间
				unlink($filename);
				return false;
			}
			return json_decode($value);
			//$value= json_decode(file_get_contents($filename),true);
		}
	}

}
