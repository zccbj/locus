<?php
namespace app\controller;
use app\model\OBJ as OBJ;
use app\model\BLL as BLL;
use framework\tool as tool;
class FriendController extends \framework\lib\Controller{
	//添加好友
	public function addFriendAction(){
		//添加
		$data=$_POST['data'];
		$addArr=json_decode($data,true);
		$addFromView=new OBJ\FriendInfoObjModel($addArr);
		$addFromView->addDateTime=date('YmdHis');
		$addFromView->boolAccept='w';
		
		$FriendBLLModel=new BLL\FriendBLLModel();
		$FriendInfoSignFromDb=$FriendBLLModel->iFriendInfo($addFromView);
		
		if($FriendInfoSignFromDb===417){
			echo tool\ResponseTool::show(417,'he is your friend',null);
		}else if ($FriendInfoSignFromDb) {
			echo tool\ResponseTool::show(1,'friend start add',null);
		}else{
			echo tool\ResponseTool::show(418,'friend add failure',null);
		}
	}
	public function getNewFriendAction(){
		//得到新朋友列表
		$userId=$_POST['userId'];
		$friendFromView=new OBJ\FriendInfoObjModel();
		$friendFromView->userId=$userId;
		$friendBLLModel=new BLL\FriendBLLModel();
		$friendArrFromDb=$friendBLLModel->sFriendInfoByUserId($friendFromView);
		if($friendArrFromDb){
			echo tool\ResponseTool::show(1,'new friend list',$friendArrFromDb);
		}else{
			echo tool\ResponseTool::show(419,'no new friend',null);
		}
		
		
	}
	public function agreeFriendAction(){
		//同意成为好友
		$data=$_POST['data'];
		$addArr=json_decode($data,true);
		$addFromView=new OBJ\FriendInfoObjModel($addArr);


		$friendBLLModel=new BLL\FriendBLLModel();
		$friendSignFromDb=$friendBLLModel->iFriendAndInfo($addFromView);
		if($friendSignFromDb){
			echo tool\ResponseTool::show(1,'add success',null);
		}else{
			echo tool\ResponseTool::show(420,'add failure',null);
		}
		
		
	}
	public function refuseFriendAction(){
		//拒绝成为好友
		$data=$_POST['data'];
		$addArr=json_decode($data,true);
		$addFromView=new OBJ\FriendInfoObjModel($addArr);

		$friendBLLModel=new BLL\FriendBLLModel();
		$friendSignFromDb=$friendBLLModel->refuseFriendInfo($addFromView);
		if($friendSignFromDb){
			echo tool\ResponseTool::show(1,'refuse success',null);
		}else{
			echo tool\ResponseTool::show(421,'refuse failure',null);
		}
	}
	public function deleteFriendAction(){
		//删除好友
		$userId=$_POST['userId'];
		$masterId=$_POST['masterId'];
		$friendFromView=new OBJ\FriendInfoObjModel();
		$friendFromView->userId=$userId;
		$friendFromView->masterId=$masterId;
		$friendBLLModel=new BLL\FriendBLLModel();
		$friendSignFromDb=$friendBLLModel->dFriendAndInfo($friendFromView);
		if($friendSignFromDb){
			echo tool\ResponseTool::show(1,' friend delete',null);
		}else{
			echo tool\ResponseTool::show(422,'friend delete failure',null);
		}
	}

}