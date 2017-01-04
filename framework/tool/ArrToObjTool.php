<?php
namespace framework\tool;
use framework\lib;
class ArrToObjTool{
	//数组的key不能为数字
	public static function arrToObj($array,$objName) {
		  if (is_array($array)) {
		    $obj =lib\Factory::getObj($objName);
		    foreach ($array as $key => $val){
		    	if (!is_numeric($key)) {
		    		$obj->$key = $val;
		    	}
		      
		    }
		  }
		  else { $obj = $array; }
		  return $obj;
	}
	//返回对象数组
	public static function arr2ToObj($array=null,$objName=null) {
		if (count($array)!=count($array,1)) {
			//说明为二维数组
			foreach ($array as $k => $v) {
				$obj =lib\Factory::getObj($objName);
				foreach ($v as $key => $value) {
					if (!is_numeric($key)) {
		    			$obj->$key = $value;
		    		}
				}	
				$objArr[]=$obj;	
			}
			return $objArr;
		}else{
			return null;
		}		
	}
	//二维数组转二维数组
	public static function arr2ToArr2($array=null) {
		if (count($array)!=count($array,1)) {
			//说明为二维数组
			$arr2 =array();
			foreach ($array as $k => $v) {
				
				foreach ($v as $key => $value) {
					if (!is_numeric($key)) {
		    			$arr[$key]=$value;
		    		}
				}	
				$arr2[]=$arr;	
			}
			return $arr2;
		}else{
			return null;
		}		
	}
	//对象数组转换为二维数组
	public static function objArrToArr($obj){
		foreach ($obj as $key => $value) {
			$a=$value->objToArr();				
			$arr[]=$a;
		}
		return $arr;
	}

}