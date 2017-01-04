<?php
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class EventController extends \framework\lib\Controller{
	//得到用户eventype
	public function addEventAction(){
		
		$data=$_POST['data'];

		$eventArr=json_decode($data,true);
	
		$eventFromView=new OBJ\EventObjModel($eventArr);

		$eventFromView->eventDate=date('Ymd');
		$eventFromView->eventTime=date('His');
		
		$eventBLLModel=new BLL\EventBLLModel();
		$eventFromDb=$eventBLLModel->iEvent($eventFromView);
		if ($eventFromDb) {
			echo tool\ResponseTool::show(1,'event add',null);
		}else{
			echo tool\ResponseTool::show(414,'event not add',null);
		}
	}
	public function deleteEventAction(){
		$eventId=$_POST['eventId'];
		$eventFromView=new OBJ\EventObjModel();
		$eventFromView->eventId=$eventId;
		$eventBLLModel=new BLL\EventBLLModel();
		$eventFromDb=$eventBLLModel->dEvent($eventFromView);
		if ($eventFromDb) {
			echo tool\ResponseTool::show(1,'event delete',null);
		}else{
			echo tool\ResponseTool::show(415,'event delete fail',null);
		}


	}
	public function getAllEventAction(){
		//得到所有事件
		$eventBLLModel=new BLL\EventBLLModel();
		$eventArrFromDb=$eventBLLModel->sAllEvent();
		if ($eventArrFromDb) {
			
			echo tool\ResponseTool::show(1,'event ',$eventArrFromDb);
		}else{
			echo tool\ResponseTool::show(416,'event not found',null);
		}
	}

}