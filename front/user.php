<?php
/**
 * 会员
 * @author johz
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
require_once PRO_ROOT . 'include/orderFun.class.php';
require_once PRO_ROOT . 'include/userFun.class.php';

class userViews {
	/**
	 * 用户中心主页
	 */
	public static function index() {
		auth::authUser();
		$uid = auth::getUserId();
		//$uid = 2979; //Debug
		//用户信息
		try{
			$user = user::objects()->get("uid = $uid");
		}catch (Exception $e) {
			$user = '';
		}
		//等级
		try{
			$member = member::objects()->get("id = $user->member");
		}catch (Exception $e) {
			$member = '';
		}
		//积分
		try{
			$integral = integral::objects()->get("uid = $uid");
			$score = empty($integral->score) ? 0 : $integral->score;
		}catch (Exception $e) {
			$score = 0;
		}
		//完成的订单数量
		global $db;
		try {
			$sql = "SELECT COUNT(id) FROM orders WHERE uid = $uid AND orderstate = 3";
			$rs = $db->prepare($sql);
			$rs->execute();
			$orderDone = $rs->fetchColumn();
		} catch (DZGException $e) {
			$orderDone = 0;
		}
		//账户余额
		$url = PAYURL . '?act=4';
		$key = 'dl47ca8d62';
		$signMsg = md5($uid . $key);
		$money = @file_get_contents("&accountId=$uid&key=$key&signMsg=$signMsg");
		//总消费额
		try {
			$sql = "SELECT SUM(pay) FROM orders WHERE uid = $uid AND paystate = 1";
			$rs = $db->prepare($sql);
			$rs->execute();
			$consume = $rs->fetchColumn();
		} catch (DZGException $e) {
			$consume = 0;
		}
		//未读短信
		try {
			$sql = "SELECT COUNT(id) FROM shortmessage WHERE tid = $uid AND smtype = 0";
			$rs = $db->prepare($sql);
			$rs->execute();
			$sm = $rs->fetchColumn();
		} catch (DZGException $e) {
			$sm = 0;
		}
		//咨询回复
		try {
			$sql = "SELECT COUNT(id) FROM question WHERE uid = $uid AND state = 1";
			$rs = $db->prepare($sql);
			$rs->execute();
			$qr = $rs->fetchColumn();
		} catch (DZGException $e) {
			$qr = 0;
		}
		//待付款订单
		try {
			$sql = "SELECT COUNT(id) FROM orders WHERE uid = $uid AND paystate = 0 AND orderstate != 2";
			$rs = $db->prepare($sql);
			$rs->execute();
			$wp = $rs->fetchColumn();
		} catch (DZGException $e) {
			$wp = 0;
		}
		//订单
		try{
			$order = orders::objects()->get("uid = $uid", 'createtime DESC');
		}catch (Exception $e) {
			$order = '';
		}
		//待评价的商品
		try{
			$corder = orders::objects()->filter("uid = $uid AND orderstate = 3");
		}catch (Exception $e) {
			$corder = '';
		}
		$cgoods = array();
		foreach ($corder as $i=>$v) {
			try{
				$tmp = goodsorder::objects()->filter("orderid = $v->id AND goods_type = 0");
				$cgoods = array_merge($cgoods, $tmp);
			}catch (Exception $e) {
			}
		}
		$cid = array();		
		foreach ($cgoods as $i=>$v) {
			try{
				comment::objects()->get("goodsid = $v->goodsid AND uid = $uid");
			}catch (Exception $e) {
				$cid[] = $v->goodsid; 
			}
		}
		$cid = array_unique($cid);
		$wc = array();
		foreach ($cid as $i=>$v) {
			try{
				$wc[] = goodsorder::objects()->get("goodsid = $v AND uid = $uid AND goods_type = 0");
			}catch (Exception $e) {
			}
		}
		//文章
		try{
			$article = article::objects()->filter(NULL, "createtime DESC", 0, 5);
		}catch (Exception $e) {
			$article = '';
		}
		//关联商品
		try{
			$rorder = orders::objects()->filter("uid = $uid", "createtime DESC", 0, 6);
		}catch (Exception $e) {
			$rorder = '';
		}
		$rgoods = array();
		foreach ($rorder as $i=>$v) {
			try{
				$rgoods[] = goodsorder::objects()->get("orderid = $v->id");
			}catch (Exception $e) {
			}
		}
		$reco = array();
		foreach ($rgoods as $i=>$v) {
			try{
				$tmp = goodsrelevancy::objects()->get("parentgoodsid = $v->goodsid");
				try{
					$reco[] = goods::objects()->get("id = $tmp->goodsid");
					try{
						$tmp = goodsattachment::objects()->get("goodsid = $tmp->goodsid");
						$tmp = attachment::objects()->get("id = $tmp->aid");
						$reco_pic[] = URL . $tmp->apath . $tmp->filename . '.' . $tmp->atype;
					}catch (Exception $e) {
						$reco_pic[] = URL . 'media/img/no_picture.gif';
					}					
				}catch (Exception $e) {
				}
			}catch (Exception $e) {
			}
		}
		$navigation = NAV_MY;
		$array = array('user'=>$user, 'member'=>$member, 'score'=>$score, 'orderDone'=>$orderDone, 
				'consume'=>$consume, 'sm'=>$sm, 'wp'=>$wp, 'qr'=>$qr, 'order'=>$order, 'wc'=>$wc, 
				'article'=>$article, 'reco'=>$reco, 'reco_pic'=>$reco_pic, 
				'navigation'=>$navigation, 'uname'=>$user->uname);
		template('index', $array, 'default/front/user');
	}

	/**
	 * 实例化 jsonClient
	 */
	public static function &instanceJson() {
		static $object;
		if(empty($object)) {
			include_once DZG_ROOT . '/core/webservice/json.php';
			$config = new webServiceConfig(APPID,SERVICEKEY,SERVICESERVER, SERVICEPORT, SERVICEURL);
			$object = new jsonClient($config);
		}
		return $object;
	}


	/**
	 * 用户注册
	 */
	public static function userReg() {

		base::checkRefresh();  //防刷新
		$username =  $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$rurl = urldecode($_GET["ref"]);
		$seccode = $_POST['seccode'];

		if (empty($username)) {
			template("register", array(), 'default/front/user');
			exit();
		}

		if( base::checkCode('isreg') ) {  //是否需要验证码
			if ( strtoupper($seccode) != strtoupper($_SESSION['seccode']) ) {
				core::alert('验证码错误');
				exit();
			}
		}

        if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
        {
             core::alert('用户名含非法字符，请重试。');
        }

        if (!preg_match("/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i", $email))
        {
            core::alert('Email格式错误，请返回重试。');
        }

        $json = self::instanceJson();
		if($json->xmlCheckUserName($username)==1){
            core::alert('用户名已被使用，请返回重试');
		}elseif($json->xmlCheckEmail($email)==1){
            core::alert('邮箱已被使用，请返回重试');
		} else {
			$result = $json->xmlReg($username, md5($password), $email);      //写入 通行证
			$rs = userFun::addUser( '', $username, '1', '', '', $email, $result); //写入 商场会员
			$id = base::getInsertId();
			if ($result && $rs) {
				auth:: setUserLogin($result, $username, $email, 0, $id); //写入身份验证
				user::objects()->QuerySql("update user set lastlogintime=".time()." where uid='$result'");       //记录最后登录时间
				template("reged", array('rurl'=>$rurl,'username'=>$username), 'default/front/user');
			} else {
				core::alert('注册失败，请返回重试');
			}
		}

	}

	/*
	 * 检查并是否登录，获取标题行
	*/
	public static function checklogin(){
		require_once PRO_ROOT.'include/userFun.class.php';
		$headline = userFun::GetHeadLine();
		echo $headline;
	}

	/**
	 * 用户登录
	 */
	public static function userLogin() {
		$username = trim( $_POST['username']);
		$password = trim( $_POST['password']);
		$rurl     = urldecode($_GET["ref"]);
		$rename   = $_POST["rename"];
		$auto_login=$_POST["auto_login"];

		if (empty($username)) {
			template("login", array(), 'default/front/user');
			exit();
		}

        $fro = parse_url($rurl);
		if($fro['host']!=$_SERVER['HTTP_HOST']){
			$rurl = '';
		}

        $json = self::instanceJson();
		if( $password=='' || $username=='' ){
            core::alert('用户名和密码不能为空');
		} else {
			$result = $json->xmlLogin($username, $password);      //判断通行证 帐号 密码   返回通行证id  不正确则抛出错误
			if($result>0){
			
				if(self::checkShopUser($username)) {                   //检查商场的user表是否已写入用户
					$rs = true; 
					$shopinfo = user::objects()->get("uid = $result");
					$id =  $shopinfo->id ;                                          //已存在则直接赋true
				} else {

				    $info = $json->getUserInfoByUserId($result);          //根据通行证id获取会员信息
				    $email = $info['member_email'];

					$rs = userFun::addUser( '', $username, '1', '', '', $email, $result ); // 未存在 则 写入到商场会员
					$id = base::getInsertId();
				}                  

				if ($result && $rs) {
					if($auto_login == '1'){                     //自动登录  保存cookie一个星期
						$time = 3600*24*7;
					}

					if($rename == '1'){                                                                //记住用户名
						setcookie("mtk_rename",$username, time()+3600*24*30, '/', DZG_COOKIEDOMAIN);
					}
					//写入身份验证
					auth::setUserLogin($result, $username, $email, $time, $id);
					user::objects()->QuerySql("update user set lastlogintime=".time()." where uid='$result'");       //记录最后登录时间
					//core::alert('登录成功');
					if($rurl) {
						core::redirect("您已经成功登录！", $rurl);
					} else {
						core::redirect("您已经成功登录！", URL);
					}

				} else {
					core::alert('登录失败，请返回重试');
				}
			} else if($result=='-2') {
				core::alert('用户不存在！');
			} else if($result=='-3') {
				core::alert('密码不正确！');
			} else {
				core::alert('用户名密码不正确！');
			}



		}

	}

    /*
	* 用户资料编辑
	*/
	public function editInfo(){
		auth::authUser();

		$mobile = htmlspecialchars( $_POST['mobile'],ENT_QUOTES);
		$address = htmlspecialchars( $_POST['address'],ENT_QUOTES);
		$fullname = htmlspecialchars($_POST['fullname'],ENT_QUOTES);
		$type = $_POST['type'];
		$sex  = $POST['sex'];
		$birthday = $_POST['y'].'-'.$_POST['m'].'-'.$_POST['d'];
        $province = $_POST['province'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$idcard = htmlspecialchars($_POST['idcard'],ENT_QUOTES);
		$phone = htmlspecialchars($_POST['idcard'],ENT_QUOTES);
		$zipcode = htmlspecialchars($_POST['zipcode'],ENT_QUOTES);
		$remark = htmlspecialchars($_POST['remark'],ENT_QUOTES);
		$headpic = basename($_POST['headpic']);
		$seccode = $_POST['seccode'];

        $id = auth::getShopUserId();
		if (empty($mobile) && empty($address) && empty($_POST['act']) && empty($_FILES['uppic']['name'])) {
			$navigation = NAV_MY . '> <a>个人资料</a>';
			$userInfo = user::objects()->get("id = $id");
			template("editInfo", array('userInfo'=>$userInfo,'uname'=>auth::getUserName(),'navigation'=>$navigation), 'default/front/user');
		}

		$user = new user();
		$user->id = $id;

		/** 上传头像 **/
		if($_FILES['uppic']['name']!=""){
			
			$fileType = array('image/gif','image/pjpeg','image/jpg','image/bmp','image/png','image/jpeg');
			if($_FILES['uppic']['name']!=""){
				if(in_array($_FILES['uppic']['type'],$fileType)){
					$ext_arr =explode('.',$_FILES['uppic']['name']);
					move_uploaded_file($_FILES['uppic']['tmp_name'],PRO_ROOT.'uploadfile/headpics/user/'.$id.'.'.$ext_arr[1]);

					require_once DZG_ROOT.'core/image/gd.php';                                              //缩略图
					 $imgfile = PRO_ROOT.'uploadfile/headpics/user/'.$id.'.'.$ext_arr[1];
					 $dst = PRO_ROOT.'uploadfile/headpics/user/'.$id.'_s';
					$img = new gd($imgfile);
				    $img->createThumb($dst,80,80,true);

				}else{
					core::alert("不支持此文件类型，请重新选择！");
				}
			}
			$user->headpic = '/user/'.$id.'_s'.'.'.$ext_arr[1] ;
			$rs = $user->save();
			if($rs){
				core::alert("头像上传成功！");
			} else {
				core::alert("头像上传失败！");
			}
			exit();
		}
        /** 设置头像 **/
        if($_POST['act']=='savepic'){
			$user->headpic = '/sys/'.$headpic ;
			$rs = $user->save();
			if($rs){
				core::alert("头像设置成功！");
			} else {
				core::alert("头像设置失败！");
			}
			exit();
		}
		if ( strtoupper($seccode) != strtoupper($_SESSION['seccode']) ) {
			core::alert('验证码错误');
			exit();
		}
		$user->mobile = $mobile;
		$user->address = $address;
		$user->fullname = $fullname;
		$user->type = $type;
		$user->sex = $sex;
		$user->birthday = $birthday;
		$user->province = $province;
		$user->city = $city;
		$user->district = $district;
		$user->idcard = $idcard;
		$user->phone = $phone;
		$user->zipcode = $zipcode;
		$user->remark = $remark;
		$rs = $user->save();
		
		if ($rs){
			core::alert('修改成功！');
		}else {
			core::alert('修改失败！');
		}
	}


    /*
	* 用户修改密码
	*/
	public function editPwd(){
		auth::authUser();

		$oldpwd = trim( $_POST['oldpwd']);
		$newpwd = trim( $_POST['newpwd']);
		$renewpwd = trim( $_POST['renewpwd']);

        $id = auth::getShopUserId();
		$uname = auth::getUserName();
		$uid = auth::getUserId();
        $json = self::instanceJson();
		$info = $json->getUserInfoByUserId($uid);

		if (empty($oldpwd) || empty($newpwd)) {
			$navigation = NAV_MY . '> <a>修改密码</a>';
			template("editPwd", array('uname'=>$uname,'navigation'=>$navigation), 'default/front/user');
		}


		if($newpwd!=$renewpwd){
			core::alert('两次输入的新密码不一致！');	
			exit();
		}else {
			if($json->editUserPassword( $uid, md5($oldpwd), md5($newpwd), $info['member_email'] )){
				core::alert('修改成功！');
			} else {
				core::alert('修改失败！');
			}
		}
	}

    /*
	* 用户登出
	*/
	public function userLogout(){
		auth::SetUserLogOut();
		core::redirect('您已经成功退出！', URL);
	}
	
	/**
	 * 我的积分
	 */
	public function myIntegral() {
		auth::authUser();
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		try{
			$integral = integral::objects()->get("uid = $uid");
			$integral = $integral->score;
		}catch (Exception $e) {
			$integral = 0;
		}
		$page = intval($_GET['page']);
		$manager = orders::objects()->pageFilter("uid = $uid", 'createtime DESC');  //按下单时间倒序排列
		$page = new pagination($manager, PAGE_SIZE, $page);  //分页
		$navigation = NAV_MY . '> <a>我的积分</a>';
		template('myIntegral', array('integral'=>$integral, 'page'=>$page, 'navigation'=>$navigationl, 'uname'=>$uname), 'default/front/user');		
	}
	
	/**
	 * 我的级别
	 */
	public function myLevel() {
		auth::authUser();
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		try{
			$user = user::objects()->get("uid = $uid");
		}catch (Exception $e) {
			$user = false;
		}
		try{
			$member = member::objects()->get("uid = $user->member");
		}catch (Exception $e) {
			$member = false;
		}
		$navigation = NAV_MY . '> <a>我的级别</a>';
		template('myLevel', array('member'=>$member, 'navigation'=>$navigation, 'uname'=>$uname), 'default/front/user');
	}

	/**
	 * 检查用户名是否已存在, 1是已存在，0是未存在
	 * @param $username
	 */
	public function checkName($username=''){
		$username = ($username)?$username:$_GET['username'];
        $json = self::instanceJson();
		echo $json->xmlCheckUserName($username);
	}

	/**
	 * 检查email是否已存在, 1是已存在，0是未存在
	 * @param $email
	 */
	public function checkEmail($email=''){
		$email = ($email)?$email:$_GET['email'];
        $json = self::instanceJson();
		echo $json->xmlCheckEmail($email);
	}

	/**
	 * 检查验证码是否正确，1正确，0错误
	 * @param $seccode
	 */
	public function checkSeccode($seccode=''){
		$seccode = ($seccode)?$seccode:$_GET['seccode'];
		if (strtoupper($seccode) == strtoupper($_SESSION['seccode']))
			echo '1';
		else
			echo '0';
	}

	/**
	 * 检查商场用户user表是否存在，主要用于通行证第一次登陆商场时  1 存在   0 不存在
	 * @param $uname
	 */
	public static function checkShopUser($uname){
		$uname = ($uname)?$uname:$_GET['uname'];
		try {
			user::objects()->get("uname = '$uname'");
			return true;
		} catch (Exception $e) {

		}
		return false;

	}

	/*
	* just  for test
	*/
	public function test(){
		 $json = self::instanceJson();
		 $result =($json->xmlCheckUserName('nic')==1);      //写入 通行证
		 var_dump($result);
		//$result = ($json->xmlCheckUserName('nic')==1);
		//var_dump($result);
          //if(userFun::addUser( '', 'test_joz', '1', '', '', 'johz@163.com', '15' ))
			  //echo 'ok';
		  //else
			 // echo 'false';
	}


	
}