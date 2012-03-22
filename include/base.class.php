<?php
/**
 * 公共方法类
 * @author wj45
 */
class base {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}
	
	/**
	 * 检查网站是否关闭（若关闭，且$url不为空，则可以跳转到指定页面了；$url为空直接显示关闭原因）
	 */
	public static function checkClose( $url = '' ) {
		$close = intval(CLOSE);
		if ($close == 1) {
			if ( empty($url) ) {
				echo CLOSE_REASON;
			} else {
				core::redirect('网站已关闭', $url);
			}
		}
	}
	
	/**
	 * 防刷新，如果重复刷新则直接退出程序
	 */
	public static function checkRefresh() {
		session_start();
		$time = time() + microtime();
		$sid = $_SERVER['PHP_SELF'];
		$sid = 'mall_' . $sid;  //生成session名称
		if ( isset($_SESSION[$sid]) ){
			if (($time - $_SESSION[$sid]) < 0.5) {  //0.5秒 最短时间间隔
				exit();  //直接退出
				return true;
			}
		}
		$_SESSION[$sid] = $time;
		return false;
	}
	
	/**
	 * 生成静态网页
	 * 前三个参数的使用与使用template()的方法一致
	 * 第四个参数为生成的静态网页存放的目录+文件名
	 */
	public static function makeHtml($tpl_name, $tpl_data = array(), $tpl_path = 'default', $html_file = '' ) {
		$tmpPath = PRO_ROOT . 'template/' . $tpl_path . '/' . $tpl_name . '.php';
		
		if (file_exists($tmpPath)) {
			$TplFile = $tmpPath;
		} else {
			die('模板文件不存在');
		}
		extract($tpl_data);  //导入变量
		//OB
		ob_start();
		include($TplFile);
		$result = ob_get_contents();
		ob_clean();

		$handle = fopen($html_file, 'w');
		if ($handle) {
			fwrite($handle, $result);  //写入静态文件
			fclose($handle);
			echo "$html_file 生成成功";
		} else {
			echo "$html_file 生成失败";
		}
		echo '<br/>';
	}
	
	/**
	 * 将文章的content部分静态存放
	 * 参数：文件创建时间（UNIX时间戳）、文件名称、要写入的内容
	 */
	public static function setContent( $time, $file, $content ) {
		$date = date('Ym', $time);
		$dir = 'content/' . $date . '/';  //文件夹
		if ( !is_dir($dir) ){
			mkdir($dir);  //按月份创建文件夹
		}
		$file = $dir . $file . '.html';  //文件以ID命名
		$hd = fopen($file, 'w');
		$rs = fwrite($hd, $content);  //content生成静态文件
		return $rs;  //TRUE or FALSE
	}
	
	/**
	 * 读取文章的content部分的静态文件
	 * 参数：文件创建时间（UNIX时间戳）、文件名称
	 */
	public static function getContent( $time, $file ) {
		$date = date('Ym', $time);
		$dir = 'content/' . $date . '/';  //文件夹
		$file = $dir . $file . '.html';
		$content = file_get_contents($file);
		return $content;
	}
	
	/**
	 * 删除文章的content部分的静态文件
	 * 参数：文件创建时间（UNIX时间戳）、文件名称
	 */
	public static function clearContent( $time, $file ) {
		$date = date('Ym', $time);
		$dir = 'content/' . $date . '/';  //文件夹
		$file = $dir . $file . '.html';
		$rs = unlink($file);  //删除文件
		return $rs;  //TRUE or FALSE
	}
	
	/**
	 * 设置config文件
	 */
	public static function setConfig( $key, $value ) {
		$hd = fopen('config.php', 'r');
		$tmp = '';
		if ($hd) {
			while ( !feof($hd) ) {
				$bf = fgets($hd, 4096);
				if ( strpos($bf, $key) ) {
					$rs = self::hdConfig($bf);
					$tmp .= str_replace($rs, $value, $bf);
				} else {
					$tmp .= $bf;
				}
			}
			fclose($hd);
		}
		$hd = fopen('config.php', 'w');
		return fwrite($hd, $tmp);
	}
	
	/**
	 * 读取config文件
	 */
	public static function getConfig( $key ) {
		$hd = fopen('config.php', 'r');
		if ($hd) {
			while ( !feof($hd) ) {
				$bf = fgets($hd, 4096);
				if ( strpos($bf, $key) ) {
					return self::hdConfig($bf);
				}
			}
			fclose($hd);
		}
	}
	
	private static function hdConfig( $bf ) {
		$pos = strpos($bf, ",");
		$bf = substr($bf, $pos+2);
		$bf = str_replace(");", '', $bf);
		$bf = str_replace("'", '', $bf);
		return trim($bf);
	}
	
	/**
	 * 获取某项功能是否需要验证码
	 */
	public static function checkCode( $type ) {
		try {
			$info = authcode::objects()->get();
		} catch (Exception $e) {
			$info = '';
		}
		if (empty($info->$type) || $info->$type == 0) {
			return false;  //不需要验证码或数据库中无信息，直接返回FALSE
		} else {
			return array('width'=>$info->codewidth, 'height'=>$info->codeheight);  //返回长宽的值
		}
	}
	
	/**
	 * 获取某项功能是否需要验审核
	 */
	public static function checkVerify( $type ) {
		try {
			$info = verify::objects()->all();
		} catch (Exception $e) {
			$info = '';
		}
		foreach ($info as $v) {
			if ($v->key == $type) {
				if ($v->value == '1') {
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * 自定义自动跳转页面
	 * 参数分别为该页面的提示标题、提示内容、要跳转到的页面
	 */
	public static function autoSkip($title = '操作成功！', $content = '直接进入', $href = '', $time = 10, $content2 = '', $href2 = '') {
		template('autoSkip', array('title'=>$title, 'content'=>$content, 'href'=>$href, 'time'=>$time,
				'content2'=>$content2, 'href2'=>$href2), 'default/admin');
	}
	
	/**
	 * 取数据库刚刚插入的自增ID
	 */
	public static function getInsertId() {
		global $db;
		try {
			$sql = "SELECT last_insert_id()";  //取插入数据的自增ID
			$rs = $db->prepare($sql);
			$rs->execute();
			$id = $rs->fetchColumn();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$id = '';
		}
		return $id;
	}
	
	/**
	 * 过滤屏蔽的关键字
	 */
	public static function wordFilter( $str ) {
		$str = htmlspecialchars($str, ENT_QUOTES);
		try {
			$words = wordfilter::objects()->all();
		} catch (Exception $e) {
			$words = '';
		}
		foreach ($words as $i=>$v) {
			$str = str_replace($v->source, $v->replace, $str);
		}
		return $str;
	}
	
	/**
	 * 写入管理员日志
	 * 参数：要写入日志的文字内容
	 */
	public static function setAdminLog ( $content = '' ) {
		AdminAuth::AuthAdmin();
		$id = AdminAuth::GetAdminId();
		//写入数据库
		$admin = new adminlog();
		$admin->adminid = $id;
		$admin->logcontent = $content;
		$admin->ip = $_SERVER['REMOTE_ADDR'];
		$admin->logtime = time();
		if ( $admin->save() ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 取得商品的名称
	 */
	public static function getGoodsName( $id ) {
		try {
			$goods = goods::objects()->get("id = $id");
		} catch (Exception $e) {
			return false;
		}
		return $goods->goodsname;
	}

	/**
	 * 取得商品的信息
	 */
	public static function getGoodsInfo( $id ) {
		try {
			$goods = goods::objects()->get("id = $id");
		} catch (Exception $e) {
			return false;
		}
		return $goods;
	}
	
	/**
	 * 取得用户的用户名
	 */
	public static function getUserName( $id ) {
		try {
			$user = user::objects()->get("uid = $id");
		} catch (Exception $e) {
			return false;
		}
		return $user->uname;
	}

	/**
	 * 获取Ip
	 */
	 function GetIp(){
		if(getenv('HTTP_CLIENT_IP')) { 
		$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR')) { 
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR')) { 
		$onlineip = getenv('REMOTE_ADDR');
		} else { 
		$onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
		}
		return $onlineip;
	 }
	
	/**
	 * 取得管理员的用户名
	 */
	public static function getAdminName( $id ) {
		try {
			$admin = admininfo::objects()->get("id = $id");
		} catch (Exception $e) {
			return false;
		}
		return $admin->uname;
	}
	
	/**
	 * 取得管理员的角色描述
	 */
	public static function getAdminDes( $id ) {
		try {
			$admin = admininfo::objects()->get("id = $id");
		} catch (Exception $e) {
			return false;
		}
		return $admin->des;
	}
	
	/**
	 * 由ID获得品牌名称
	 */
	public static function getBrandName( $id ) {
		try {
			$brand = brand::objects()->get("id = $id");
		} catch (Exception $e) {
			return false;
		}
		return $brand->bname;
	}
	
	/**
	 * 获取会员等级的名称
	 */
	public static function getMemberName( $id ) {
		try {
			$member = member::objects()->get("id = $id");
			$member = $member->mname;
		} catch (Exception $e) {
			$member = false;
		}
		return $member;
	}
	
	/**
	 * 获得某一级的全部地区数据（地区）
	 */
	public static function getRegionAll( $level = 0 ) {
		try {
			$region = region::objects()->filter("region_type = $level", '', 0, 100);
		} catch (Exception $e) {
			$region = false;
		}
		return $region;
	}
	
	/**
	 * 获得某个地区的下一级地区数据（地区）
	 */
	public static function getRegion( $pid = 0 ) {
		try {
			$region = region::objects()->filter("parent_id = $pid", '', 0, 100);
		} catch (Exception $e) {
			$region = false;
		}
		return $region;
	}
	
	/**
	 * 通过ID获得某个地区的名称（地区）
	 */
	public static function getRegionName( $id = 0 ) {
		try {
			$region = region::objects()->get("id = $id");
			$region = $region->region_name;
		} catch (Exception $e) {
			$region = false;
		}
		return $region;
	}

	/**
	 * 获取当前url即参数 (此方法只用于GET方式提交)
	 * 2010/05/13 link
	 */
	public static function getUrl(){
		$linkArray = explode( "page=", $_SERVER['QUERY_STRING'] );
		$linkArg = $linkArray[0];
		if ( $linkArg=='' )
			$link = $_SERVER['PHP_SELF'] . "?";
		else
		{
			$linkArg = substr( $linkArg, -1 ) == "&" ? $linkArg : $linkArg . '&';
			$url = $_SERVER['PHP_SELF'] . '?' . $linkArg;
			$link = substr($url,0,$url.length-1); 
		}
		return $link;
	}
	
	/*
	 * 读取csv文件
	*/
	public static function ParseCSV($filename){
		$data = array();
		if(file_exists($filename)){
			$handle = fopen($filename,'r');
			setlocale(LC_ALL,array('zh_CN.gb2312'));
			while($tmp=fgetcsv($handle,1000,',')){
				$data[] = $tmp; 
			}
		}else{
			core::alert($filename."此文件不存在");
		}
		return $data;
	}
	
	/*
	 * 将gb2312 转换成utf-8的格式
	*/
	public static function conv($str){
		return iconv('GB2312','UTF-8',$str);
	}
}

class Uploadfile {
	public $upload_name = ''; 
	public $upload_tmp_address = ''; 
	public $upload_server_name = ''; 
	public $upload_filetype = ''; 
	public $file_type = ''; 
	public $file_server_address = '';
	public $upload_file_size = '';
	public $upload_must_size= 3000000; //允许上传文件的大小，自己设置
	public $folder = '';
	public $suffix = '';
	public $path = '';
	public function __construct(){
	}
	
	function upload_file($folder,$filetypeArr,$filename,$name='',$id=''){
		$this->folder = $folder;
		$this->name = $name;
		$this->id = $id;
		$this->file_type = $filetypeArr;//允许上传文件的类型
		
		for($i=0;$i<count($_FILES[$filename]['name']);$i++){
			if($_FILES[$filename]['name'][$i]!=''||$_FILES[$filename]['name'][$i]!=null){
				$this->upload_name[$i] = $_FILES[$filename]['name'][$i]; //取得上传文件名
				$this->suffix[$i] =explode('.',$_FILES[$filename]['name'][$i]);
				$this->upload_filetype[$i] = $_FILES[$filename]['type'][$i];
				$this->upload_server_name[$i] = $this->name.$i.'_'.$this->id.'_'.date("YmdHis",(time()+60*60*8));
				$this->upload_tmp_address[$i] = $_FILES[$filename]['tmp_name'][$i];//取得临时地址
				//$this->file_type = array('image/gif','image/pjpeg','image/jpg','image/bmp','image/png'); 
				$this->upload_file_size[$i] = $_FILES[$filename]['size'][$i]; //上传文件的大小
				
				if(in_array($this->upload_filetype[$i],$this->file_type)) {
					if($this->upload_file_size[$i] < $this->upload_must_size){
						$this->file_server_address = $this->folder.'/'.$this->name.$i.'_'.$this->id.'_'.date("YmdHis",(time()+60*60*8)).'.'.$this->suffix[$i][1];
						move_uploaded_file($this->upload_tmp_address[$i],$this->file_server_address);//从TEMP目录移出
					}else{
							echo('文件容量太大');
					}
				}else{
					echo('不支持此文件类型，请重新选择');
				}
			}
		}
	}

	/*
	 *	以时间年月创建目录
	 * @param String $root 自定义的二级根目录
	 * @param int $user 当前用户
	 * @param int $num 目录类型1根据用户名生成，2根据时间
	 */
	function CreatePath($root,$user,$num=2){
		if($num==2){
			$apath='uploadfile'.'/'.$root.'/'.date('Y',time()).'/'.date('m',time()).'/';
		}elseif($num==1){
			$apath='uploadfile'.'/'.'Pic_'.$user.'/'.$root.'/';
		}
		if(!file_exists($apath)){
			if(mkdir($apath,0700,true)){
				$this->path = $apath;
			}else{
				$this->path = '';
			}
		}else{
			$this->path = $apath;
		}
	}
	
	/*
	 * 获取静态文件
	*/
}
?>