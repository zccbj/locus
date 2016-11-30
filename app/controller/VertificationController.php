<?php 
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class VertificationController extends \framework\lib\Controller{
	//忘记密码，发送msg
	public function sendMsgAction(){
		//1查询用户是否存在
		//2存在，发短信
		$telNumber=$_POST['telNumber'];
		$user=new OBJ\UserObjModel();
		$user->telNumber=$telNumber;
		$userBLL=new BLL\UserBLLModel();
		$userObjFromDb=$userBLL->sUserByTel($user);
		if (is_null($userObjFromDb)) {
			echo tool\ResponseTool::show(412,'user not register',null); 
			die();
		}else{
				$verificationObj=new OBJ\VerificationObjModel();
				$verificationObj->telNumber=$telNumber;

		//进行发短信
				$verificat=new BLL\VerificationBLLModel;
				$verificatObjFromDb=$verificat->sendAndAdd($verificationObj);
				if ($verificatObjFromDb) {
					echo tool\ResponseTool::show(1,'send message ok',null);
				}
		}
		
	}
	public function verificatMsgAction(){
		//1,验证验证码
		//2,添加用户信息
		$telNumber=$_POST['telNumber'];
		$verificationNumber=$_POST['verificationNumber'];
		//$password=$_POST['password'];
		$verificationObj=new OBJ\VerificationObjModel;
		$verificationObj->telNumber=$telNumber;
		$verificationObj->verificationNumber=$verificationNumber;
		$verificat=new BLL\VerificationBLLModel;
		$verificatFromDb=$verificat->checkVerification($verificationObj);


		if (is_object($verificatFromDb)&&$verificatFromDb!=null) {
			//验证成功，
			echo tool\ResponseTool::show(1,'verification ok',null);
		}else if (is_numeric($verificatFromDb)) {
			if ($verificatFromDb==402) {
				echo tool\ResponseTool::show(402,'timeout verification',null);
			
			}elseif ($verificatFromDb==403) {
				echo tool\ResponseTool::show(403,'error verification',null);
				
			}
		}else{
				echo tool\ResponseTool::show(404,'fault verification',null);
		}
		

				
	}
	public function resetPswAction(){
		$telNumber=$_POST['telNumber'];
		$password=$_POST['password'];
		$user=new OBJ\UserObjModel();
		$user->telNumber=$telNumber;
		$user->password=md5($password.'djtu');
		$userBLL=new BLL\UserBLLModel();
		$userSignFromDb=$userBLL->uUserPsw($user);
		if ($userSignFromDb>=0) {
			echo tool\ResponseTool::show(1,'password changed',null);
				
		}else{
			echo tool\ResponseTool::show(413,'fault changedPw',null);
				
		}
	}
	
}