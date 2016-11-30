<?php
namespace app\model\DAL;
use framework\lib as lib;
use framework\tool as tool;
class UserDALModel extends lib\Model{
	protected $table_name='user';
	//通过telNumber查询用户
	public function selectByTel($telNumber){
		$sql="select * from {$this->table_name} where telNumber=$telNumber";
		$userArr=$this->db->fetchRow($sql);
		if ($userArr) {
			return tool\ArrToObjTool::arrToObj($userArr,'User');
		}else{
			return null;
		}
		
	}
	//insert一个user
	public function insertByTel($userArr){
		
		$reslut=$this->autoInsert($userArr);
		return $reslut;
		//成功则返回1
	}
	public function updateUserPsw($telNumber,$password){
		//返回影响行数
		$sql="update {$this->table_name} set password='$password' where telNumber='$telNumber' ";
		$userSign=$this->db->affectedRows($sql);
		echo $userSign;
	die();
		return $userSign;
	}

}