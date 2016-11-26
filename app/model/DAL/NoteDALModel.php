<?php
namespace app\model\DAL;
use framework\lib as lib;
use framework\tool as tool;
class NoteDALModel extends lib\Model{

	protected $table_name='note0';
	//添加note取出最近添加的note。
	public function insertNote($noteObjArr,$noteNum){
		$this->table_name='note'.$noteNum;
		//var_dump($noteObjArr);
		if ($reslut=$this->autoInsert($noteObjArr)) {

			$noteObj=$this->selectByNoteBoardIdNew($noteObjArr['noteBoardId'],$noteNum);
			return $noteObj;
		}else{
			return false;
		}
	}

	//insert方法需要用。//按添加时间排序
	public function selectByNoteBoardIdNew($noteBoardId,$noteNum){
		$this->table_name='note'.$noteNum;

		$sql=$this->from($this->table_name)->where("noteBoardId='$noteBoardId'")->order("noteDateTime desc")->select();
	
		$noteObjFromDbArr=$this->db->fetchRow($sql);
		return tool\ArrToObjTool::arrToObj($noteObjFromDbArr,'Note');
	}
	//返回一维数组obj
	public function selectByNoteId($noteId,$noteNum){
		$this->table_name='note'.$noteNum;
		return tool\ArrToObjTool::arrToObj($this->autoSelectRow($noteId),'Note');	
	}


		//返回二维数组obj
	public function selectByNoteBoardId($noteBoardId,$noteNum){
		$this->table_name='note'.$noteNum;
		$sql=$this->from($this->table_name)->where("noteBoardId='$noteBoardId'")->select();
		$erArr=$this->db->fetchAll($sql);

		return tool\ArrToObjTool::arr2ToObj($erArr,'Note');
	}
	public function updateByNoteArr($noteObjArr,$noteNum){
		$this->table_name='note'.$noteNum;
		$noteId=$noteObjArr['noteId'];

		if ($message=$this->autoUpdate($noteObjArr)) {
			$noteObjFromDb=$this->selectByNoteId($noteId,$noteNum);
			return $noteObjFromDb;
		}
	}
	public function delByNoteId($noteId,$noteNum){
		$this->table_name='note'.$noteNum;
		return $this->autoDelete($noteId);
	}

}