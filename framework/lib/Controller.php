<?php
namespace framework\lib;
class Controller{
	public  $assign;
	public function assign($key,$value){
		$this->assign[$key]=$value;

	}
	public function display($file){
		$file=VIEW_DIR.$file;
		if (is_file($file)) {
			extract($this->assign);//把数组打散变成变量。
			include $file;

		}
	}
	
}