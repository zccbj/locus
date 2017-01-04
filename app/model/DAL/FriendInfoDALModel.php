<?php
namespace app\model\DAL;
use framework\lib as lib;
use framework\tool as tool;
class FriendInfoDALModel extends lib\Model{
	protected $table_name='friendInfo';
	public function insertFriendInfo($friendInfoArr){
		//返回ture or false
		$reslut=$this->autoInsert($friendInfoArr);
	 	return $reslut;
	
	}
	// public function selectEventType($userId){
	// 	//返回evenType的二维数组
	// 	$sql="select * from {$this->table_name} where userId=$userId";
	// 	$reslut=$this->db->fetchAll($sql);
	// 	return $reslut;
	// }
	// public function selectAllEvent(){
	// 	//返回evenType的二维数组
	// 	$sql="select * from {$this->table_name} order by eventDate,eventTime desc";
	// 	$reslut=$this->db->fetchAll($sql);
		
	// 	return tool\ArrToObjTool::arr2ToArr2($reslut);
		
	// }
	public function selectFriendInfoByUserId($userId){
		//返回一个二维数组,可能为null
		$sql="select * from {$this->table_name} where userId=$userId order by addDateTime desc";
		$reslut=$this->db->fetchAll($sql);
		return tool\ArrToObjTool::arr2ToArr2($reslut);
		
	}
	public function selectFriendInfoByUM($userId,$masterId){
		//返回一个用户对象
		$sql="select * from {$this->table_name} where userId=$userId and masterId=$masterId";
		$reslut=$this->db->fetchRow($sql);
		if ($reslut) {
			return tool\ArrToObjTool::arrToObj($reslut,'FriendInfo');
		}else{
			return null;
		}
		
	}
	public function updateFriendInfo($friendInfoArr){
		//返回
		$reslut=$this->autoUpdate($friendInfoArr);
	 	
		return $reslut;

		
	}

	// public function insertEvetType($evetTypeArr){
	// 	//返回1 or 0
	// 	$reslut=$this->autoInsert($evetTypeArr);
	// 	return $reslut;

	// }


}