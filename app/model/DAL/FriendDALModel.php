<?php
namespace app\model\DAL;
use framework\lib as lib;
use framework\tool as tool;
class FriendDALModel extends lib\Model{
	protected $table_name='friend';
	public function insertFriend($friendArr){
		//返回ture or false
		$reslut=$this->autoInsert($friendArr);
	 	return $reslut;
	
	}
	public function selectFriendByUM($userId,$masterId){
		//返回一个用户对象
		$sql="select * from {$this->table_name} where userId=$userId and masterId=$masterId";
		$reslut=$this->db->fetchRow($sql);
		if ($reslut) {
			return tool\ArrToObjTool::arrToObj($reslut,'Friend');
		}else{
			return null;
		}
		
	}
	public function updateFriend($userId,$masterId,$friendType){
		//返回
		$sql="update {$this->table_name} set friendType='$friendType' where userId=$userId and masterId=$masterId";
		$reslut=$this->db->query($sql);

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
	
	// public function selectEventTypeById($eventTypeId){
	// 	//返回evenType
	// 	$reslut=$this->autoSelectRow($eventTypeId);
	// 	return tool\ArrToObjTool::arrToObj($reslut,'EventType');
	// }

	// public function insertEvetType($evetTypeArr){
	// 	//返回1 or 0
	// 	$reslut=$this->autoInsert($evetTypeArr);
	// 	return $reslut;

	// }


}