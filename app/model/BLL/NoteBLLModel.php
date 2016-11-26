<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class NoteBLLModel{
	//g,d,m,a,
	//封装了得到noteBoardId的值。
	public function gNoteBoardId($userId){
		$noteBoardDALModel=new DAL\NoteBoardDALModel;
		$noteBoardObjFromDb=$noteBoardDALModel->selectByUserId($userId);
		$noteBoardId=$noteBoardObjFromDb->noteBoardId;
		return $noteBoardId;
	}
	//获取note信息，二维
	public function infoNote($noteBoardObjFromView){
		$userId=$noteBoardObjFromView->userId;
		 $noteBoardId=$this->gNoteBoardId($userId);
		 if ($noteBoardId==null) {
		 	return null;
		 	// return tool\ResponseTool::show(414,'noteBoardId不匹配',null);
		 }
		 $noteNum=$noteBoardId%7;
		$noteDALModel=new DAL\NoteDALModel;
		$noteObjArrFromDb=$noteDALModel->selectByNoteBoardId($noteBoardId,$noteNum);
		//返回的为多个对象的数组集合。
		return $noteObjArrFromDb;
		// $a=tool\ArrToObjTool::objArrToArr($noteObjArrFromDb);

		// return tool\ResponseTool::show(1,'note查询成功',$a);
		
	}
	//获取note信息，一维
	public function infoNoteById($noteBoardObjFromView,$noteId){

		$userId=$noteBoardObjFromView->userId;
		$noteBoardId=$this->gNoteBoardId($userId);
		if ($noteBoardId==null) {
		 	return nulll;
		 //	return tool\ResponseTool::show(414,'noteBoardId不匹配',null);
		}
		$noteNum=$noteBoardId%7;

		$noteDALModel=new DAL\NoteDALModel;
		$noteObjFromDb=$noteDALModel->selectByNoteId($noteId,$noteNum);
		return $noteObjFromDb;
		// if ($noteObjFromDb) {
		// 	$a=$noteObjFromDb->objToArr();
		// 	return tool\ResponseTool::show(1,'note查询成功',$a);
		// }else{
		// 	return tool\ResponseTool::show(410,'note查询失败2',null);
		// }
		
	}
	public function addNote($userId,$noteObjFromView){

		$noteBoardId=$this->gNoteBoardId($userId);
		$noteNum=$noteBoardId%7;

		if ($noteBoardId==null) {
			return null;
		 //	return tool\ResponseTool::show(410,'noteBoardId寻找失败',null);
		}

		if ($noteObjFromView->noteBoardId==null) {
			//不传noteboardid
			$noteObjFromView->noteBoardId=$noteBoardId;
		}else if($noteObjFromView->noteBoardId!=$noteBoardId){
			//id与useid不匹配
			return null;
			//return tool\ResponseTool::show(414,'noteBoardId不匹配',null);
		}
		$noteObjArr=$noteObjFromView->objToArr();
		$noteObjArr['noteBoardId']=$noteBoardId;
		$noteDALModel=new DAL\NoteDALModel;
		$noteObjFromDb=$noteDALModel->insertNote($noteObjArr,$noteNum);
		return $noteObjFromDb;
		// if ($noteObjFromDb) {
	 //      	return tool\ResponseTool::show(1,'note添加成功',$noteObjFromDb->objToArr());
		// }else{
		// 	return tool\ResponseTool::show(411,'note添加失败',null);
	
		// }
	}
	public function modifyNote($noteObjFromView){


		$noteObjArr=$noteObjFromView->objToArr();
		$noteBoardId=$noteObjArr['noteBoardId'];
		$noteNum=$noteBoardId%7;
		$noteDALModel=new DAL\NoteDALModel;
		$noteObjFromDb=$noteDALModel->updateByNoteArr($noteObjArr,$noteNum);
		return $noteObjFromDb;
		// if ($noteObjFromDb) {

		// 	return tool\ResponseTool::show(1,'note修改成功',$noteObjFromDb->objToArr());
		// }else{
		// 	return tool\ResponseTool::show(412,'note修改失败',null);
		// }
			
	
		
		
	}
	//返回1或者0
	public function delNote($userId,$noteObjFromView){

		$noteBoardId=$this->gNoteBoardId($userId);
		$noteNum=$noteBoardId%7;
		$noteId=$noteObjFromView->noteId;
		$noteDALModel=new DAL\NoteDALModel;
		$sign=$noteDALModel->delByNoteId($noteId,$noteNum);
		return $sign;
// 		if ($sign) {
// 			return tool\ResponseTool::show(1,'note删除成功',null);
	

// 		}else{
// 			return tool\ResponseTool::show(413,'note删除失败',null);		}

 		}
 }
