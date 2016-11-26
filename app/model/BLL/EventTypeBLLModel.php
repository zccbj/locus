<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class EventTypeBLLModel{
	public function iEventTypeDefault($eventTypeObjFromView){
      $eventTypeDALModel=new DAL\EventTypeDALModel();
      $eventTypeSignFromDb=$eventTypeDALModel->insertEventTypeDefault($eventTypeObjFromView->userId);
      return $eventTypeSignFromDb;
	}
 	
 }
