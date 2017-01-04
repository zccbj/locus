<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class EventBLLModel{
	//添加事件
	public function iEvent($eventObjFromView){
      $eventDALModel=new DAL\EventDALModel();
      $eventFromDb=$eventDALModel->insertEvent($eventObjFromView->ObjToArr());
      return $eventFromDb;
	}
 // 	//查找用户的eventType
	public function sAllEvent(){
		//返回二维数组
      $eventDALModel=new DAL\EventDALModel();
      $eventArrFromDb=$eventDALModel->selectAllEvent();
      return $eventArrFromDb;
	}
	// public function sEventTypeUF($eventTypeObjFromView){
	// 	//用户刚插入的eventType
	// 	$eventTypeDALModel=new DAL\EventTypeDALModel();
 //      $eventTypeObjFromDb=$eventTypeDALModel->selectEventTypeF($eventTypeObjFromView->userId);
 //      return $eventTypeObjFromDb;

	// }
	// public function sEventTypeById($eventTypeObjFromView){
	// 	//用户eventType通过eventTypeId
	// 	$eventTypeDALModel=new DAL\EventTypeDALModel();
 //      $eventTypeObjFromDb=$eventTypeDALModel->selectEventTypeById($eventTypeObjFromView->eventTypeId);
 //      return $eventTypeObjFromDb;

	// }
	// //插入eventType
	// public function iEventType($eventTypeObjFromView){

	// 	$eventTypeDALModel=new DAL\EventTypeDALModel();
 //      $eventTypeSignFromDb=$eventTypeDALModel->insertEvetType($eventTypeObjFromView->objToArr());
   
 //      if ($eventTypeSignFromDb) {
 //   			return $this->sEventTypeUF($eventTypeObjFromView);
 //      }else{
 //      	return $eventTypeSignFromDb;
 //      }
      
	// }

	public function dEvent($eventObjFromView){
		$eventDALModel=new DAL\EventDALModel();
      $eventFromDb=$eventDALModel->deleteEvet($eventObjFromView->eventId);
  	
      return $eventFromDb;
	}
 }
