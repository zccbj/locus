<?php 
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class RegisterController extends \framework\lib\Controller{
	//与vertification表相关
	//用户注册时，发送msg
	public function sendMsgAction(){
		//用户已存在？前端已验证
		$telNumber=$_POST['telNumber'];
		$verificationObj=new OBJ\VerificationObjModel();
		$verificationObj->telNumber=$telNumber;

//进行注册
		$verificat=new BLL\VerificationBLLModel;
		$verificatObjFromDb=$verificat->sendAndAdd($verificationObj);
		if ($verificatObjFromDb) {
			echo tool\ResponseTool::show(1,'send message ok',null);
		}
		
	}
	public function verificatMsgAction(){
		//1,验证验证码
		//2,添加用户信息
		$telNumber=$_POST['telNumber'];
		$verificationNumber=$_POST['verificationNumber'];
		$password=$_POST['password'];
		$verificationObj=new OBJ\VerificationObjModel;
		$verificationObj->telNumber=$telNumber;
		$verificationObj->verificationNumber=$verificationNumber;
		$verificat=new BLL\VerificationBLLModel;
		$verificatFromDb=$verificat->checkVerification($verificationObj);


		if (is_object($verificatFromDb)&&$verificatFromDb!=null) {
			//验证成功，对用户进行添加
				$user=new OBJ\UserObjModel();
				$user->telNumber=$verificatFromDb->telNumber;
				$user->password=md5($password.'djtu');
				$userBLL=new BLL\UserBLLModel();
				$user=$userBLL->iUserByTel($user);
			
				if ($user==null) {
					echo tool\ResponseTool::show(405,'user add error',null);
				}
				//还有对类别表进行添加
				$eventTypeObjFromView=new OBJ\EventTypeObjModel();
				$eventTypeObjFromView->userId=$user->userId;
				$eventTypeBLLModel=new BLL\EventTypeBLLModel();
				$eventTypeObjFromBb=$eventTypeBLLModel->iEventTypeDefault($eventTypeObjFromView);
				
			if ($eventTypeObjFromBb&&$user) {
				echo tool\ResponseTool::show(1,'Tel Register ok',$user->objToArr());
		
			}
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
	
}