<?php
namespace framework\lib;
/**
 * 作用：FTP操作类( 拷贝、移动、删除文件/创建目录 )
 */
header("Content-Type: text/html; charset=UTF-8");
class Ftp{
    public $off; // 返回操作状态(成功/失败)
    public $conn_id; // FTP连接
    public $eventName;
//    public $defpath;
    // const FTP_HOST='*.*.*.*';
    // const FTP_PORT='21';
    // const FTP_USER='*******';
    // const FTP_PSW='*******';
    /**
    * 方法：FTP连接
    * @FTP_HOST -- FTP主机
    * @FTP_PORT -- 端口
    * @FTP_USER -- 用户名
    * @FTP_PASS -- 密码
    */
    
    public function __construct(){
     
        $options=conf::get('OPTION','ftp');
   //     $this->defpath=conf::get('FTP_PATH','ftp');
        $this->conn_id = @ftp_connect($options['FTP_HOST'],$options['FTP_PORT']) or die("FTP服务器连接失败");
          @ftp_login($this->conn_id,$options['FTP_USER'],$options['FTP_PSW']) or die("FTP服务器登陆失败");
          @ftp_pasv($this->conn_id,1); // 打开被动模拟


    }

    /**
    * 方法：上传文件
    * @path -- 本地路径
    * @newpath -- 上传路径
    * @type -- 若目标目录不存在则新建
     */
     public function up_file($path,$newpath,$type)
     {

        // if (!file_exists($this->path.date('Ymd'))) {//is_file($file)file_exists($file).当$file是目录时，is_file返回false，file_exists返回true
        //         // echo('arg1');
        //         mkdir($this->path.date('Ymd'),0777,true);

        //     }
        //     return file_put_contents($this->path.date('YmdH').'/'.$file.'.php', date('Y-m-d H-i-s').json_encode($message).PHP_EOL,FILE_APPEND);
        // }

         //var_dump($this->conn_id);exit;
        
        
         if(!$type) {
            //说明路径不存在
            $this->dir_mkdirs($newpath);


         }
         //target需要有。jpg
         $this->off = @ftp_put($this->conn_id,$newpath,$path,FTP_BINARY);
         if(!$this->off) echo "文件上传失败，请检查权限及路径是否正确！111";
     }
     /**
     * 方法：移动文件
     * @path -- 原路径
     * @newpath -- 新路径
     * @type -- 若目标目录不存在则新建
     */
     public function move_file($path,$newpath,$type=true)
     {
         if($type) $this->dir_mkdirs($newpath);
         $this->off = @ftp_rename($this->conn_id,$path,$newpath);
         if(!$this->off) echo "文件移动失败，请检查权限及原路径是否正确！";
     }
     /**
     * 方法：复制文件
     * 说明：由于FTP无复制命令,本方法变通操作为：下载后再上传到新的路径
     * @path -- 原路径
     * @newpath -- 新路径
     * @type -- 若目标目录不存在则新建
     */
     public function copy_file($path,$newpath,$type=true)
     {
         $downpath = "c:/tmp.dat";
         $this->off = @ftp_get($this->conn_id,$downpath,$path,FTP_BINARY);// 下载
         if(!$this->off) echo "文件复制失败，请检查权限及原路径是否正确！";
         $this->up_file($downpath,$newpath,$type);
     }
     /**
     * 方法：删除文件
     * @path -- 路径
     */
    public function del_file($path)
     {
         $this->off = @ftp_delete($this->conn_id,$path);
         if(!$this->off) echo "文件删除失败，请检查权限及路径是否正确！";
     }
     /**
     * 方法：生成目录
     * @path -- 路径
     */
     public function dir_mkdirs($path)
     { //不用跟目录的／

         $path_arr = explode('/',$path); // 取目录数组

         $file_name = array_pop($path_arr); // 弹出文件名

         $path_div = count($path_arr); // 取层数

         foreach($path_arr as $k=>$val) // 创建目录
          {
            if (empty($val)) {
                continue;
            }
            if(@ftp_chdir($this->conn_id,$val) == FALSE){
                
                $tmp = @ftp_mkdir($this->conn_id,$val);
                  if($tmp == FALSE){
                      echo "目录创建失败，请检查权限及路径是否正确！";
                      //exit;
                 }
                 @ftp_chdir($this->conn_id,$val);
             }
         }

        //  echo ftp_pwd($this->conn_id);//输出当前目录
         
         for($i=1;$i<=$path_div;$i++) // 回退到根
         {
            @ftp_cdup($this->conn_id);
         }
        
     }
     /**
     * 方法：关闭FTP连接
         */
    public function close(){
        @ftp_close($this->conn_id);
    }
}// class class_ftp end
     
     /************************************** 测试 ***********************************
     $ftp = new class_ftp('192.168.100.143',21,'user','pwd'); // 打开FTP连接
     //$ftp->up_file('aa.txt','a/b/c/cc.txt'); // 上传文件
     //$ftp->move_file('a/b/c/cc.txt','a/cc.txt'); // 移动文件
     //$ftp->copy_file('a/cc.txt','a/b/dd.txt'); // 复制文件
     //$ftp->del_file('a/b/dd.txt'); // 删除文件
     $ftp->close(); // 关闭FTP连接
     ******************************************************************************/
?>