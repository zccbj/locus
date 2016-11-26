<?php
namespace framework\lib;
	//单例模式。连接数据库封装
class MySQLDB{
	private $host;
	private $port;
	private $user;
	private $pass;
	private $charset;
	private $dbname;

	private $link;
	private $last_sql;

	private static $instance;
	public static function getInstance($options){
		if (! (self::$instance instanceof self)) {
			self::$instance=new self($options);
		}
		return self::$instance;

	}
	private function __construct($options=array()){
	//有这构造方法，类外的兄弟们不能new	
		$this->host=isset($options['DB_HOST'])?$options['DB_HOST']:'127.0.0.1';
		$this->port=isset($options['DB_PORT'])?$options['DB_PORT']:'3306';
		$this->user=isset($options['DB_USER'])?$options['DB_USER']:'rot';
		$this->pass=isset($options['DB_PWD'])?$options['DB_PWD']:'16';
		$this->charset=isset($options['DB_CHARSER'])?$options['DB_CHARSER']:'utf8';
		$this->dbname=isset($options['DB_NAME'])?$options['DB_NAME']:'dbname';
		$this->connect();
		$this->setCharst();
	}
	private function connect(){
		$this->link=mysqli_connect($this->host,$this->user,$this->pass,$this->dbname) or die('111');

	}
	
	private function setCharst(){
		$sql="set names $this->charset";
		return $this->query($sql);
	}
	public function query($sql){
		$this->last_sql=$sql;
		$result=mysqli_query($this->link,$sql);
		if($result===false){
			Log::init();//日志
			Log::log($sql.'|'.mysqli_error($this->link));//日志
			echo "sql错误";
			echo "出错sql:",$sql;
			echo '错误代码是：', mysqli_errno($this->link), '<br>';
			echo '错误信息是：', mysqli_error($this->link), '<br>';
			
			die;
		}else{
			return $result;
		}
	}
	public function fetchAll($sql){
		//返回一个二维数组
		if ($result=$this->query($sql)) {
			$rows=array();
			while ($row=mysqli_fetch_array($result)) {
				$rows[]=$row;
			}
			mysqli_free_result($result);
			return $rows;
		}else{
			return false;
		}
	}
	public function fetchRow($sql){
		//返回一维数组
		if ($result=$this->query($sql)) {
			$row=mysqli_fetch_array($result);
			mysqli_free_result($result);
			return $row;
		}else{
			return false;
		}
	}
	public function fetchColumn($sql){
		//返回一维数组中的第一个
		if ($result=$this->query($sql)) {
			if($row=mysqli_fetch_array($result)){
				return $row[0];
				mysqli_free_result($result);
			}
			
		}else{
			return false;
		}
	}
	public function affectedRows($sql){
		//update可能没有影响任何
		//除select。。。。。select用这个mysqli_num_rows($reslut);
		$result=$this->query($sql);
		return mysqli_affected_rows($this->link);
		//一个 > 0 的整数表示所影响的记录行数。0 表示没有受影响的记录。-1 表示查询返回错误。	
	}
	public function numRows($sql){
		$result=$this->query($sql);
		return mysqli_num_rows($result);//返回结果集中行的数目
	}

}