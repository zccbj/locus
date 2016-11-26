<?php
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class EventTypeController extends \framework\lib\Controller{
	//得到用户eventype
	public function getUserEventTypeAction(){
		$userId=$_POST['userId'];
		$eventTypeFromView=new OBJ\EventTypeObjModel();
		$eventTypeFromView->userId=$userId;
		$eventTypeBLLModel=new BLL\EventTypeBLLModel();
		$eventTypeArr=$eventTypeBLLModel->sEventType($eventTypeFromView);
		if ($eventTypeArr) {
			
			echo tool\ResponseTool::show(1,'eventType found',$eventTypeArr);
		}else{
			echo tool\ResponseTool::show(408,'eventType not found',null);
		}
	}
	//删除eventType
	public function deleteEventTypeAction(){
		$eventTypeId=$_POST['eventTypeId'];
	//	$userId=$_POST['userId'];
		$eventTypeFromView=new OBJ\EventTypeObjModel();
		$eventTypeFromView->eventTypeId=$eventTypeId;
		$eventTypeFromView->userId=$userId;
		$eventTypeBLLModel=new BLL\EventTypeBLLModel();
		$eventTypeSign=$eventTypeBLLModel->dEventType($eventTypeFromView);
		if ($eventTypeSign) {
			
			echo tool\ResponseTool::show(1,'eventType delete',null);
		}else{
			echo tool\ResponseTool::show(409,'eventType not delete',null);
		}
	}
	//添加eventType
	public function addEventTypeAction(){
		$data=$_POST['data'];
		$eventTypeArr=json_decode($data,true);
		$eventTypeFromView=new OBJ\EventTypeObjModel($eventTypeArr);
		
		$eventTypeBLLModel=new BLL\EventTypeBLLModel();
		$eventTypeObjFromDb=$eventTypeBLLModel->iEventType($eventTypeFromView);
		if ($eventTypeObjFromDb) {
			echo tool\ResponseTool::show(1,'eventType add',$eventTypeObjFromDb->objToArr());
		}else{
			echo tool\ResponseTool::show(410,'eventType not add',null);
		}
	}
	//更新eventType
	public function updateEventTypeAction(){
		$data=$_POST['data'];
		$eventTypeArr=json_decode($data,true);
		$eventTypeFromView=new OBJ\EventTypeObjModel($eventTypeArr);
		
		$eventTypeBLLModel=new BLL\EventTypeBLLModel();
		$eventTypeObjFromDb=$eventTypeBLLModel->uEventType($eventTypeFromView);
		if ($eventTypeObjFromDb) {
			echo tool\ResponseTool::show(1,'eventType update',$eventTypeObjFromDb->objToArr());
		}else{
			echo tool\ResponseTool::show(411,'eventType not update',null);
		}
	}

}