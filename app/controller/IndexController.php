<?php
namespace app\controller;
use framework\lib as lib;
class IndexController extends \framework\lib\Controller{
	public function indexAction(){
		// $a=\framework\lib\Factory::getCache('zcc');
		// $a->cacheData('age','12');
		// echo $a->cacheData('age');
		// $a=new \app\model\cModel();

		//  $a->add();
		//  $model=\core\lib\Db::getInstance();
		// var_dump($a);

		// $data='1111';
		// $this->assign('sex',$data);
		// $this->assign('name','zcc');
		
		// $this->display('index.html');
// 		$a=\framework\lib\Factory::getLib('upImg');
// var_dump($_FILES['file']);
		// $data=$_POST['form'];
		// var_dump($data);
		$img=new lib\UpImg($_FILES['file']);
		$a=\framework\lib\Factory::getLib('Ftp');
		$save=$img->savaPath.$img->saveName.$img->postFix;
		
		$a->eventName=$img->saveName.$img->postFix;
		
		$a->up_file($img->tmp_name,$save,0);
			
			
	}
}