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
		return tool\ArrToObjTool::arrToObj($userArr,'User');
	}
	//insert一个user
	public function insertByTel($userArr){
		
		$reslut=$this->autoInsert($userArr);
		return $reslut;
		//成功则返回1
	}

}