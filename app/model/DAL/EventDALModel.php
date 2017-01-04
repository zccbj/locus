<?php
namespace app\model\DAL;
use framework\lib as lib;
use framework\tool as tool;
class EventDALModel extends lib\Model{
	protected $table_name='event';
	public function insertEvent($eventArr){
		//返回ture or false
		$reslut=$this->autoInsert($eventArr);
	 	return $reslut;
	
	}
	// public function selectEventType($userId){
	// 	//返回evenType的二维数组
	// 	$sql="select * from {$this->table_name} where userId=$userId";
	// 	$reslut=$this->db->fetchAll($sql);
	// 	return $reslut;
	// }
	public function selectAllEvent(){
		//返回evenType的二维数组
		$sql="select * from {$this->table_name} order by eventDate,eventTime desc";
		$reslut=$this->db->fetchAll($sql);
		
		return tool\ArrToObjTool::arr2ToArr2($reslut);
		
	}
	
	// public function selectEventTypeById($eventTypeId){
	// 	//返回evenType
	// 	$reslut=$this->autoSelectRow($eventTypeId);
	// 	return tool\ArrToObjTool::arrToObj($reslut,'EventType');
	// }
	public function deleteEvet($evetId){
		//返回ture or false
		$reslut=$this->autoDelete($evetId);
		return $reslut;

	}
	// public function insertEvetType($evetTypeArr){
	// 	//返回1 or 0
	// 	$reslut=$this->autoInsert($evetTypeArr);
	// 	return $reslut;

	// }


}