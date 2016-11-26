<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class VerificationBLLModel{
	public function sendAndAdd($verificationObjFromView){
		$tel=$verificationObjFromView->telNumber;
		$num=mt_rand(100000,999999);
		$verificationObjFromView->verificationNumber=$num;
		$verificationObjFromView->createTime=date('Y-m-d H:i:s');
		// echo date('Y-m-d H:i:s',strtotime('+20 minute'));
		// echo(strtotime("now") . "<br>");
		$verificationObjFromView->telNumber=$tel;
	// $data="num=$num&tel=$tel";
	// echo 'send message:'.$data;
		// $curlobj=curl_init();
		// curl_setopt($curlobj,CURLOPT_URL,"http://localhost/tbsdk/test.php");
		// curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,1);
		// curl_setopt($curlobj,CURLOPT_POST,1);
		// curl_setopt($curlobj,CURLOPT_POSTFIELDS,$data);
		// curl_setopt($curlobj,CURLOPT_HTTPHEADER,array("application/x-www-form-urlencoded; charset=utf-8", "Content-length: ".strlen($data)));
		// $rtn=curl_exec($curlobj);
		// if(!curl_errno($curlobj)){
		// 	echo  $rtn;

		// }else{
		// 	echo 'Curl error'.curl_errno($curlobj);
		// }
		// curl_close($curlobj);
		$verificationArr=$verificationObjFromView->objToArr();
		$verificationDAL=new DAL\VerificationDALModel();
		$already=$verificationDAL->selectBytelNumber($verificationArr['telNumber']);
		if (!empty($already)) {//已经存在了这个家伙
			$verificationArr['verificationId']=$already->verificationId;
			$verificatObjFromDb=$verificationDAL->updateMessage($verificationArr);
		}else{
			$verificatObjFromDb=$verificationDAL->insertMessage($verificationArr);
		}
		return $verificatObjFromDb;
	//	return tool\ResponseTool::show(1,'send message ok',$verificatObjFromDb->objToArr());


	}
	public function checkVerification($verificationObjFromView){
		$verificationDAL=new DAL\VerificationDALModel();
		$verificatObjFromDb=$verificationDAL->selectBytelNumber($verificationObjFromView->telNumber);

		$message=$verificatObjFromDb->verificationNumber;
		$theTime=$verificatObjFromDb->createTime;

		if (strtotime("$theTime +20 minute")<strtotime("now")) {
			//超出了有效时间
			return 402;
		}else{
			if ($verificationObjFromView->verificationNumber!=$message) {
				//验证错误
				return 403;
			}
			else{
				
				return $verificatObjFromDb;
			}
		}

		
		

	}
}