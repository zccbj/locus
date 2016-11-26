<?php
namespace app\model\DAL;
use framework\lib as lib;
use framework\tool as tool;
class EventTypeDALModel extends lib\Model{
	protected $table_name='eventType';
	public function insertEventTypeDefault($userId){
		//返回ture or false
		$sql=" call pro_eventTpye_insert($userId)";
		$reslut=$this->db->query($sql);
		return $reslut;
	}
	public function selectEventType($userId){
		//返回evenType的二维数组
		$sql="select * from {$this->table_name} where userId=$userId";
		$reslut=$this->db->fetchAll($sql);
		return $reslut;
	}
	public function selectEventTypeF($userId){
		//返回evenType的刚插入的记录
		$sql="select * from {$this->table_name} where userId=$userId order by eventTypeId desc";
		$reslut=$this->db->fetchRow($sql);
		return tool\ArrToObjTool::arrToObj($reslut,'EventType');
	}
	
	public function selectEventTypeById($eventTypeId){
		//返回evenType
		$reslut=$this->autoSelectRow($eventTypeId);
		return tool\ArrToObjTool::arrToObj($reslut,'EventType');
	}
	public function deleteEvetType($evetTypeId){
		//返回ture or false
		$reslut=$this->autoDelete($evetTypeId);
		return $reslut;

	}
	public function insertEvetType($evetTypeArr){
		//返回1 or 0
		$reslut=$this->autoInsert($evetTypeArr);
		return $reslut;

	}
	public function updateEvetType($evetTypeArr){
		//返回1 or 0
		$reslut=$this->autoUpdate($evetTypeArr);
		return $reslut;

	}

}