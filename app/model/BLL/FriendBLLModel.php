<?php
namespace app\model\BLL;
use app\model\OBJ as OBJ;
use app\model\DAL as DAL;
use framework\tool as tool;
class FriendBLLModel{
	//使用friendinfo和friend DAL。
	
	public function iFriendInfo($friendInfoObjFromView){
		//发送一个添加好友请求在info里
		//返回 sign
		
      $friendInfoDALModel=new DAL\FriendInfoDALModel();

      $isExist=$this->sFriendInfoByUM($friendInfoObjFromView);

	 if($isExist->boolAccept=='y'){
		//说明这两人已是朋友
      	$friendInfoSignFromDb=417;
      }else if($isExist){
      	$friendInfoObjFromView->friendInfoId=$isExist->friendInfoId;
      	$friendInfoSignFromDb=$this->uFriendInfo($friendInfoObjFromView);
      }else{
      	$friendInfoSignFromDb=$friendInfoDALModel->insertFriendInfo($friendInfoObjFromView->ObjToArr());
     	 
      }

      return $friendInfoSignFromDb;

      
	}
	public function setFriendInfo($friendInfoObjFromView,$boolAccept){
		//设置friendinfo的值
		$friendInfoDALModel=new DAL\FriendInfoDALModel();
      //1改变AB为y
      $isExist=$this->sFriendInfoByUM($friendInfoObjFromView);

	 if($isExist){
	 	//更新数据库原来的数据
	 	$isExist->boolAccept=$boolAccept;
      	$sign1=$this->uFriendInfo($isExist);
      }
	//2添加BA为Y
      $userId=$friendInfoObjFromView->userId;
      $masterId=$friendInfoObjFromView->masterId;
      $friendInfoObjFromView->userId=$masterId;
      $friendInfoObjFromView->masterId=$userId;
 	  $isExist2=$this->sFriendInfoByUM($friendInfoObjFromView);
 	  if($isExist2){
 	  	//有
 	  	$isExist2->boolAccept=$boolAccept;
 	  	$sign2=$this->uFriendInfo($isExist2);
 	  }else{
 	  	//没有
 	  	$friendInfoObjFromView->friendInfoId='';
 	  	$sign2=$friendInfoDALModel->insertFriendInfo($friendInfoObjFromView->ObjToArr());
     	
 	  }

 	  return $sign2;
	}
	public function refuseFriendInfo($friendInfoObjFromView){
		//拒绝添加为好友
		$friendInfoObjFromView->addDateTime=date('YmdHis');
		$friendInfoObjFromView->boolAccept='n';
		$friendInfoObjFromView->addContent='';
     $result= $this->setFriendInfo($friendInfoObjFromView,'n');
      return $result;
	}

	public function iFriendAndInfo($friendInfoObjFromView){
		//同意添加为好友
      //1改变AB为y
	//2添加BA为Y
     
		$friendInfoObjFromView->addDateTime=date('YmdHis');
		$friendInfoObjFromView->boolAccept='n';
		$friendInfoObjFromView->addContent='';
		$result= $this->setFriendInfo($friendInfoObjFromView,'y');
   	  
      //3在friend表里添加两个记录
      $friend1=new OBJ\FriendOBJModel();
      $friend1->userId=$userId;
      $friend1->masterId=$masterId;
      $friend1->friendType='u';
      $friend2=new OBJ\FriendOBJModel();
      $friend2->userId=$masterId;
      $friend2->masterId=$userId;
	$friend2->friendType='u';
		$sign3=$this->iFriend($friend1);
		$sign4=$this->iFriend($friend2);
		
      return $sign4;

      
	}
	public function dFriendAndInfo($friendInfoObjFromView){
		//删除好友
     
		
		$friendInfoObjFromView->boolAccept='w';
		$result= $this->setFriendInfo($friendInfoObjFromView,'w');
   	
      //3在friend表里添加两个记录
      $friend1=new OBJ\FriendOBJModel();
      $friend1->userId=$friendInfoObjFromView->userId;
      $friend1->masterId=$friendInfoObjFromView->masterId;
      $friend1->friendType='d';
      $friend2=new OBJ\FriendOBJModel();
      $friend2->userId=$friendInfoObjFromView->masterId;
      $friend2->masterId=$friendInfoObjFromView->userId;
	$friend2->friendType='d';

		$sign3=$this->uFriend($friend1);
		$sign4=$this->uFriend($friend2);
		
      return $sign4;

      
	}
	public function sFriendByUM($friendObjFromView){
		//查找这个用户
		$friendDALModel=new DAL\FriendDALModel();
		
       $friendObjFromDb=$friendDALModel->selectFriendByUM($friendObjFromView->userId,$friendObjFromView->masterId);

      return $friendObjFromDb;

	}
	public function iFriend($friendObjFromView){
		//添加friend
		$friendDALModel=new DAL\FriendDALModel();

      $isExist=$this->sFriendByUM($friendObjFromView);
      if($isExist){
      	
      	$friendSignFromDb=true;
      }else{
      	$friendSignFromDb= $friendDALModel->insertFriend($friendObjFromView->ObjToArr());
     	 
      }
     	
     	return $friendSignFromDb;
	}
	public function uFriend($friendObjFromView){
		//修改friend的friendType
		$friendDALModel=new DAL\FriendDALModel();
      	$friendSignFromDb= $friendDALModel->updateFriend($friendObjFromView->userId,$friendObjFromView->masterId,$friendObjFromView->friendType);
     	 
      
     	
     	return $friendSignFromDb;
	}

	public function sFriendInfoByUserId($friendInfoObjFromView){
		//根据userId 查找需要添加的好友
		//返回二维数组
		$friendInfoDALModel=new DAL\FriendInfoDALModel();
       $friendInfoArrFromDb=$friendInfoDALModel->selectFriendInfoByUserId($friendInfoObjFromView->userId);
       if($friendInfoArrFromDb){
       		return $friendInfoArrFromDb;
       }else{
       	 return null;
       }
     
	}
	public function sFriendInfoByUM($friendInfoObjFromView){
		//查找这个用户有没有发过添加请求
		//可能返回一个对象，也可能是null
		$friendInfoDALModel=new DAL\FriendInfoDALModel();
       $friendInfoObjFromDb=$friendInfoDALModel->selectFriendInfoByUM($friendInfoObjFromView->userId,$friendInfoObjFromView->masterId);
      return $friendInfoObjFromDb;

	}
	public function uFriendInfo($friendInfoObjFromView){
		//更新一个添加请求
		$friendInfoDALModel=new DAL\FriendInfoDALModel();
      $friendInfoObjFromDb=$friendInfoDALModel->updateFriendInfo($friendInfoObjFromView->ObjToArr());
      return $friendInfoObjFromDb;

	}

 }
