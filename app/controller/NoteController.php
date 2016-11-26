<?php
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class NoteController extends \framework\lib\Controller{
	//g,d,m,a,
	//根据userid获取用户所有note
	public function gNoteAction(){
		$userId=$_POST['userId'];
		$noteBoardObj=new OBJ\NoteBoardObjModel;
		$noteBoardObj->userId=$userId;

		$noteBLLModel=new BLL\NoteBLLModel;
		$noteObjArr=$noteBLLModel->infoNote($noteBoardObj);
		//返回的是多个对象
		if ($noteObjArr) {
			$a=tool\ArrToObjTool::objArrToArr($noteObjArr);
			echo tool\ResponseTool::show(1,'note查询成功',$a);
		}else{
			echo tool\ResponseTool::show(414,'noteBoardId不匹配',null);
		}
	}
	//根据noteid和userid获取一条note
	public function gNoteByIdAction(){
		 $userId=$_POST['userId'];
		 $noteId=$_POST['noteId'];
		$noteBoardObj=new OBJ\NoteBoardObjModel;
		$noteBoardObj->userId=$userId;
		$noteBLLModel=new BLL\NoteBLLModel;
		$noteObj=$noteBLLModel->infoNoteById($noteBoardObj,$noteId);
		if ($noteObj) {
			echo tool\ResponseTool::show(1,'note查询成功',$noteObj->objToArr());
		}else{
			echo tool\ResponseTool::show(410,'note查询失败2',null);
		}
	}
	//添加一条note
	public function aNoteAction(){
		$userId=$_POST['userId'];
		$data=$_POST['data'];
		$data= json_decode($data,true);//加上true就转换成数组。不加则转换成对象
		$data['noteDateTime']=date('Y-m-d H:i:s');
		$noteObj=tool\ArrToObjTool::arrToObj($data,'Note');
		$noteBLLModel=new BLL\NoteBLLModel;
		$noteObj=$noteBLLModel->addNote($userId,$noteObj);
		if ($noteObj) {
	      	echo tool\ResponseTool::show(1,'note添加成功',$noteObj->objToArr());
		}else{
			echo tool\ResponseTool::show(414,'noteBoardId不匹配',null);
	
		}
	}
	public function uNoteAction(){
		$data=$_POST['data'];
		$data= json_decode($data,true);//加上true就转换成数组。不加则转换成对象
		$data['noteUpdateTime']=date('Y-m-d H:i:s');
		$noteObj=tool\ArrToObjTool::arrToObj($data,'Note');

		$noteBLLModel=new BLL\NoteBLLModel;
		$noteObj=$noteBLLModel->modifyNote($noteObj);
		if ($noteObj) {

			echo tool\ResponseTool::show(1,'note修改成功',$noteObj->objToArr());
		}else{
			echo tool\ResponseTool::show(412,'note修改失败',null);
		}

	}
	public function dNoteAction(){
		$noteId=$_POST['noteId'];
		$userId=$_POST['userId'];
	
		$noteObj=new OBJ\NoteObjModel;
 		$noteObj->noteId=$noteId;
 		$noteBLLModel=new BLL\NoteBLLModel;
 		$result=$noteBLLModel->delNote($userId,$noteObj);
 		if ($result) {
			echo tool\ResponseTool::show(1,'note删除成功',null);
		}else{
			echo tool\ResponseTool::show(413,'note删除失败',null);
		}


	}
}