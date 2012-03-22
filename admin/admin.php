<?php
/**
 * 管理员系统
 * @author wj45
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';

class adminViews {	
	public static function index() {
		AdminAuth::AuthAdmin();
		template('index', array(), 'default/admin/');
	}	

	/**
	 * 管理员登录
	 */
	public static function login() {
		
		
		if (!count($_POST)) {
			template("login", null, "default/admin/");
			exit();
		}
		
		$username = trim( $_POST['username'] );
		$password = trim( $_POST['password'] );
		$seccode = htmlspecialchars( $_POST['seccode'], ENT_QUOTES) ;
		if( base::checkCode('isloginman') ) {  //是否需要验证码
			if ( strtoupper($seccode) != strtoupper($_SESSION['seccode']) ) {
				core::alert('验证码错误');
				exit();
			}
		}
		if ($username == '' || $password == '') {
			core::alert('用户名或密码不能为空');
			exit();
		}
		try {
			$userInfo = admininfo::objects()->get("uname = '$username'");
		} catch (Exception $e) {
			core::alert('用户名或密码错误');
			exit();
		}
		if ($userInfo->password != md5($password)) {
			core::alert('用户名或密码错误');
			exit();
		}
		//登录记录写入数据库（这里不要使用base::setAdminLog()）
		$admin = new adminlog();
		$admin->adminid = $userInfo->id;
		$admin->logcontent = '登录系统';
		$admin->ip = $_SERVER['REMOTE_ADDR'];
		$admin->logtime = time();
		$admin->save();
		
		//写入身份验证
		AdminAuth::SetAdminLogin($userInfo->id, $userInfo->uname, $userInfo->actionlist);
		
		core::redirect("登录成功，正在跳转", URL . "index.php/admin/admin/index");
	}
	
	/**
	 * 登出
	 */
	public static function logout() {
		auth::SetUserLogOut();
		core::redirect('您已经成功退出！', URL . 'index.php/admin/admin/login');
	}

	/**
	 * 管理员的主页
	 */
	public static function main() {
		AdminAuth::AuthAdmin();
		
		require_once PRO_ROOT . 'include/other.class.php';
		require_once PRO_ROOT . 'include/goods.class.php';
		require_once PRO_ROOT . 'include/supply.class.php';
		require_once PRO_ROOT . 'include/orderFun.class.php';
		
		$uid = AdminAuth::GetAdminId();
		$uname = AdminAuth::GetAdminName();
		$des = base::getAdminDes($uid);
		//留言统计
		$quiz = other::getQuizCount();
		//缺货统计
		$goodsOut = Ware::getOutCount();
		//出库单统计
		$bill = supply::getBillCount();
		//订单统计
		$order = array();
		$order['payment'] = orderFun::getOrderCount('payment');
		$order['nopayment'] = orderFun::getOrderCount('nopayment');
		$order['carry'] = orderFun::getOrderCount('carry');
		
		
		template('main', array('uname'=>$uname, 'des'=>$des, 'quiz'=>$quiz, 'goodsOut'=>$goodsOut, 'order'=>$order, 'bill'=>$bill), 'default/admin');
	}
	
	/**
	 * 列出所有管理员（超级管理员）
	 */
	public static function adminList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(1);
		$page = intval( $_GET['page'] );
		$manager = admininfo::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, 10, $page);  //分页
		template('adminList', array('page'=>$page), 'default/admin');
	}
	
	/**
	 * 管理员日志（超级管理员）
	 */
	public static function adminLog() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(1);
		$page = intval( $_GET['page'] );
		$manager = adminlog::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, 10, $page);  //分页
		try {
			$admin = admininfo::objects()->all();  //获取管理员的name
		} catch (Exception $e) {
			$admin = '';
		}
		template('adminLog', array('page'=>$page, 'admin'=>$admin), 'default/admin');
	}
	
	/**
	 * 管理员删除日志（Ajax）（超级管理员）
	 */
	/* No Use
	public static function adminLogDel() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(1);
		base::checkRefresh();  //防刷新
		$id = $_POST['id'];
		$id = trim($id, ',');
		$id = explode(',', $id);
		if (empty($id)) {
			die();
		}
		foreach ($id as $i=>$v) {
			if (empty($v)) {
				continue;
			}
			$log = new adminlog;
			$log->id = $v;
			$log->delete();  //删除数据库数据
		}
	}
	*/
	
	/**
	 * 为管理员分配权限（超级管理员）
	 */
	public static function adminLimit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(1);
		$id = intval($_GET['id']);
		try {
			$adminInfo = admininfo::objects()->get("id = '$id'");
		} catch (Exception $e) {
			core::alert('无此管理员');
			exit();
		}
		$des = $adminInfo->des;
		$admin = explode(',', $adminInfo->actionlist);
		//获得权限列表并排序
		try {
			$limitInfo = adminpermission::objects()->all();
		} catch (Exception $e) {
		}
		$array = array();
		$array[] = $limitInfo[0];
		//排序（将每个二级权限放到对应的一级权限的后面）
		foreach ($limitInfo as $i=>$v) {
			if ( empty($limitInfo[$i]) || $i == 0) {
				continue;
			}
			$array[] = $limitInfo[$i];
			for ($j = $i+1; $j < count($limitInfo); $j++) {
				if ($v->id == $limitInfo[$j]->parentid) {
					$array[] = $limitInfo[$j];
					$limitInfo[$j] = '';  //移动过的直接清空
				}
			}
		}
		
		template('adminLimit', array('admin'=>$admin, 'limitInfo'=>$array, 'des'=>$des, 'id'=>$id), 'default/admin');
	}
	
	/**
	 * 修改管理员（超级管理员）
	 */
	public static function adminEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(1);
		$id = intval($_GET['id']);
		try {
			$adminInfo = admininfo::objects()->get("id = '$id'");
		} catch (Exception $e) {
			$adminInfo = '';
		}
		template('adminEdit', array('admin'=>$adminInfo, 'id'=>$id), 'default/admin');
	}
	
	/**
	 * 修改管理员确认提交（Ajax）（超级管理员）
	 */
	public static function adminSubmit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(1);
		base::checkRefresh();
		$id = isset($_GET['id'])?$_GET['id']:0;
		$act = $_GET['act'];
		if ((empty($id) && $act != 'add') || empty($act)){
			die('0');
		}
		//分类处理
		if ($act == 'mod') {  //修改权限
			$limit = trim($_POST['limit'], ',');  //权限分配
			$des = htmlspecialchars($_POST['role'], ENT_QUOTES);  //管理员角色描述
			$admin = new admininfo();
			$admin->id = $id;
			$admin->actionlist = $limit;
			$admin->des = $des;
			$admin->save();
			base::setAdminLog('修改管理员权限：'.$id);  //记录管理员操作
			die('1');
			
		} else if ($act == 'add') {  //增加或更新管理信息
			$uname = trim($_POST['uname']);
			$realname = trim($_POST['realname']);
			$email = trim($_POST['email']);
			$password = trim($_POST['password']);
			if (empty($uname) || empty($password)) {
				die('0');
			}
			//数据库
			$admin = new admininfo();
			if ($id != 0) {  //更新
				$admin->id = $id;
				try {
					$adminInfo = admininfo::objects()->get("id = '$id'");
				} catch (Exception $e) {
				}
				$pwd = $adminInfo->password;
			} else {  //添加：添加时检测用户名是否重复
				try {
					admininfo::objects()->get("uname = '$uname'");
					die('0');  //用户名已存在
				} catch (Exception $e) {
				}
			}
			$admin->uname = $uname;
			$admin->realname = $realname;
			$admin->email = $email;
			if ($pwd != $password) {  //如果更改了密码，则用MD5加密后更新密码
				$admin->password = md5($password);
			}
			$admin->save();
			base::setAdminLog('编辑管理员信息');  //记录管理员操作
			die('1');
			
		}  else if ($act == 'del') {  //删除
			$admin = new admininfo();
			$admin->id = $id;
			$admin->delete();
			base::setAdminLog('删除管理员：'.$id);  //记录管理员操作
			die('1');
			
		} else {
			die('0');
		}
	}

	/*
	 * Just for test
	 */
	public function cs(){
		echo TITLE;
		echo DES;
		echo KEY_WORD;
		echo CLOSE;
		echo CLOSE_REASON;
		echo '<hr/>';
		base::checkClose();
//		print_r(DZG_VERSION);
//		base::autoSkip('操作成功<-title', "点我<-content", 'http://www.baidu.com');
	}


	public function test(){
	
				try {
					admininfo::objects()->get("uname = 'johza'");
					die('0');  //用户名已存在
				} catch (Exception $e) {
				}	
	             echo "<br>1";
	}
}