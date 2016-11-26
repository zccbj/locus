<?php
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class UserController extends \framework\lib\Controller{
	//检查手机用户是否存在
	public function checkTelUserAction(){

		$telNumber=$_POST['telNumber'];
		$userObj=new Obj\UserObjModel();
		$userObj->telNumber=$telNumber;
		$userBLLModel=new BLL\UserBLLModel();
		$userObjFromDb=$userBLLModel->sUserByTel($userObj);
		if ($userObjFromDb) {
			//$a=tool\ArrToObjTool::objArrToArr($userObjFromDb);
			echo tool\ResponseTool::show(401,'user已存在',null);
		}else{
			echo tool\ResponseTool::show(1,'user不存在',null);
		}

	}
			// $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
  //       if ( preg_match( $pattern, $userName ) ){

  //       }
		
  //       if ( preg_match('/^1(3[0-9]|5[012356789]|8[0256789]|7[0678])\d{8}$/',$userName) {
        	
  //       }else{
  //       	//手机号不正确的
  //       }

	//用于用户登入
	public function loginUserAction(){
		$telNumber=$_POST['telNumber'];
		$password=$_POST['password'];
		$userObj=new Obj\UserObjModel();
		$userObj->telNumber=$telNumber;
		$userObj->password=md5($password.'djtu');
		$userBLLModel=new BLL\UserBLLModel();
		$userObjFromDb=$userBLLModel->sUserByTelLogin($userObj);
		if (is_numeric($userObjFromDb)) {
			if ($userObjFromDb==406) {
				echo tool\ResponseTool::show(406,'user not exist',null);
			}else if ($userObjFromDb==407) {
				echo tool\ResponseTool::show(407,'user password fault',null);
			}
		}
		if (is_object($userObjFromDb)) {
			echo tool\ResponseTool::show(1,'user login ok',$userObjFromDb->objToArr());
		}
		
	}

}