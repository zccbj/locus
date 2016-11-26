<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class EventTypeBLLModel{
	//注册时，默认插入的eventType
	public function iEventTypeDefault($eventTypeObjFromView){
      $eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeSignFromDb=$eventTypeDALModel->insertEventTypeDefault($eventTypeObjFromView->userId);
      return $eventTypeSignFromDb;
	}
	//查找用户的eventType
	public function sEventType($eventTypeObjFromView){
		//返回数组
      $eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeArrFromDb=$eventTypeDALModel->selectEventType($eventTypeObjFromView->userId);
      return $eventTypeArrFromDb;
	}
	public function sEventTypeUF($eventTypeObjFromView){
		//用户刚插入的eventType
		$eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeObjFromDb=$eventTypeDALModel->selectEventTypeF($eventTypeObjFromView->userId);
      return $eventTypeObjFromDb;

	}
	public function sEventTypeById($eventTypeObjFromView){
		//用户eventType通过eventTypeId
		$eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeObjFromDb=$eventTypeDALModel->selectEventTypeById($eventTypeObjFromView->eventTypeId);
      return $eventTypeObjFromDb;

	}
	//插入eventType
	public function iEventType($eventTypeObjFromView){

		$eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeSignFromDb=$eventTypeDALModel->insertEvetType($eventTypeObjFromView->objToArr());
   
      if ($eventTypeSignFromDb) {
   			return $this->sEventTypeUF($eventTypeObjFromView);
      }else{
      	return $eventTypeSignFromDb;
      }
      
	}
	//更新eventType
	public function uEventType($eventTypeObjFromView){

		$eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeSignFromDb=$eventTypeDALModel->updateEvetType($eventTypeObjFromView->objToArr());
  	
      if ($eventTypeSignFromDb) {
   			return $this->sEventTypeById($eventTypeObjFromView);
      }else{
      	return $eventTypeSignFromDb;
      }
      
	}
	public function dEventType($eventTypeObjFromView){
		$eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeSignFromDb=$eventTypeDALModel->deleteEvetType($eventTypeObjFromView->eventTypeId);
  	
      return $eventTypeSignFromDb;
	}
 	
 }
