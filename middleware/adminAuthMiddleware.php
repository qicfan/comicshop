<?php
require_once DZG_ROOT . 'core/encryption/customEncryption.php';
/**
 * 管理员登录的验证
 * @author Zeroq
 *
 */
class AdminAuth {
	public static $_admininfo;
	
	/**
	 * 验证管理员是否登录，如果没有登录则跳转到登录页面
	 */
	public static function AuthAdmin($redirect = '/admin/admin/login') {
		if (! self::isAdminLogin()) {
			header ('location:' . URL . 'index.php' . $redirect);
			exit();
		}
		return true;
	}
	
	/**
	 * 验证登录COOKIE是否存在
	 */
	public static function IsAdminLogin() {
		if (isset($_COOKIE['cm_admin_auth'])) {
			self::ParseCookie ();
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 检验管理员是否有某一项的管理权限
	 */
	public static function AdminCheck($aid, $die = 0) {
		try {
			$pid = adminpermission::objects()->get("id = $aid");
			$pid = $pid->parentid;  //如果有该权限的父权限，则也可以通过认证
		} catch (Exception $e) {
		}
		$list = explode(',', self::$_admininfo['list']);
		if ( in_array($pid, $list) || in_array($aid, $list) || in_array(1, $list) ) {  //1为超级管理员
			return true;
		} else {
			if ($die == 0) {
				die('没有权限');
			}
			return false;
		}
	}
	
	/**
	 * 设置登录的COOKIE
	 * $list 权限列表
	 */
	public static function SetAdminLogin($id, $name, $list) {
		$result = serialize(array ('id' => $id, 'name' => $name, 'list' => $list));
		setcookie( 'cm_admin_auth', customEncryption::encode($result), null, '/', DZG_COOKIEDOMAIN );
		return ;
	}
	
	/**
	 * 设置登出的COOKIE
	 */
	public static function SetAdminLogout() {
		return setcookie( 'cm_admin_auth', '', null, '/', DZG_COOKIEDOMAIN );
	}
	
	/**
	 * 解析登录的COOKIE
	 */
	public static function ParseCookie() {
		$authcode = $_COOKIE ['cm_admin_auth'];
		$authcode = customEncryption::decode ( $authcode );
		$authcode = unserialize ( $authcode );
		self::$_admininfo = $authcode;
		return true;
	}
	
	/**
	 * 从COOIE中解析出管员员的显示名称返回
	 */
	public static function GetAdminName() {
		return self::$_admininfo ['name'];
	}
	
	/**
	 * 取得管理员的ID
	 */
	public static function GetAdminId() {
		return self::$_admininfo ['id'];
	}

}