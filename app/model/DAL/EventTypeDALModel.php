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

}