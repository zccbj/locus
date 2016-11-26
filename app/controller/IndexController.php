<?php
namespace app\controller;
class IndexController extends \framework\lib\Controller{
	public function index(){
		$a=\framework\lib\Factory::getCache('zcc');
		$b=\framework\lib\Factory::getCache('zcc');
		$a->cacheData('age','12');
		echo $a->cacheData('age');
		// $a=new \app\model\cModel();

		//  $a->add();
		//  $model=\core\lib\Db::getInstance();
		// var_dump($a);

		// $data='1111';
		// $this->assign('sex',$data);
		// $this->assign('name','zcc');
		
		// $this->display('index.html');


	}
}