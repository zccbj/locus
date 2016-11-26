<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class UserBLLModel{
	//通过tel查询得到user对象
	public function sUserByTel($userObjFromView){
		$telNumber=$userObjFromView->telNumber;
		$userDALModel=new DAL\UserDALModel();
		$userObjFromDb=$userDALModel->selectByTel($telNumber);
		return $userObjFromDb;
	}
	//插入user，并且返回插入的user对象
	//新注册的用户得，需要默认添加信息
	public function iUserByTel($userObjFromView){
		$userObjFromView->nickName=uniqid('Lo_');
		
		$userObjFromView->createTime=date('Y-m-d');
		$userArr=$userObjFromView->ObjToArr();
		
		$userDALModel=new DAL\UserDALModel();
		$result=$userDALModel->insertByTel($userArr);
		if ($result) {
			$userObjFromDb=$this->sUserByTel($userObjFromView);
		}
		return $userObjFromDb;

	}
	public function sUserByTelLogin($userObjFromView){
		$userObjFromDb=$this->sUserByTel($userObjFromView);
		if (is_null($userObjFromDb)) {
			//该用户不存在
			return 406;
		}
		if ($userObjFromDb->password==$userObjFromView->password) {
			return $userObjFromDb;
		}else{
			//密码错误
			return 407;
		}
	}
 	
 }
