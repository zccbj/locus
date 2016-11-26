<?php
namespace app\model\DAL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\lib as lib;
use framework\tool as tool;
class VerificationDALModel extends lib\Model{
	protected $table_name = 'verification';
	public function insertMessage($verificationArr){
		if ($message=$this->autoInsert($verificationArr)) {
			$verifi=$this->selectBytelNumber($verificationArr['telNumber']);
			return $verifi;
		}
	}
	public function updateMessage($verificationArr){
		if ($message=$this->autoUpdate($verificationArr)) {
			$verifi=$this->selectBytelNumber($verificationArr['telNumber']);
			return $verifi;
		}
	}
	public function selectBytelNumber($telNumber){
		$sql="select * from {$this->table_name} where telNumber='$telNumber'";
		$verifiInfo=$this->db->fetchRow($sql);
		if ($verifiInfo) {
			$verifi=tool\ArrToObjTool::arrToObj($verifiInfo,'Verification');

			return $verifi;
		}else{
			return NULL;
		}
	}
}