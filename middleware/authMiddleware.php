<?php
require_once DZG_ROOT . 'core/encryption/customEncryption.php';
class auth {
	public static $userInfo;
	public static function authUser($redirect = '') {
		if (! self::isUserLogin()) {
			core::alert("请先登录。");
			//header ('location:' . URL . 'index.php' . $redirect);
			exit();
		}
		return true;
	}
	
	public static function isUserLogin() {
		if (! isset ( $_COOKIE ['cm_mall_auth'] )) {
			return false;
		}
		self::ParseCookie ();
		return true;
	}
	
	public static function getUserId() {
		return self::$userInfo ['uid'];
	}
	
	public static function getShopUserId() {
		return self::$userInfo ['id'];
	}

	public static function getUserName() {
		return self::$userInfo ['uname'];
	}
	
	public static function setUserLogin($uid, $uname, $email, $time = 0, $id='') {
		// 设定用户登录信息，即设定COOKIE。
		$result = serialize(array ('uid' => $uid, 'uname' => $uname, 'email' => $email, 'id'=>$id ));
		if ($time) {
			setcookie( 'cm_mall_auth', customEncryption::encode($result), time() + $time, '/', DZG_COOKIEDOMAIN );
		} else {
			setcookie( 'cm_mall_auth', customEncryption::encode($result), null, '/', DZG_COOKIEDOMAIN );
		}
		return ;
	}
	
	public static function ParseCookie() {
		$authcode = $_COOKIE ['cm_mall_auth'];
        if($authcode==''){
		    self::$userInfo = array();
		    return true;
		}
		$authcode = customEncryption::decode ( $authcode );
		while(1) {
			$last = $authcode{strlen($authcode) - 1};
			if ($last != '}') {
				$authcode = substr_replace($authcode, '', -1, 1);
			} else {
				break;
			}
		}
		$authcode = unserialize ( $authcode );
		self::$userInfo = $authcode;
		return true;
	}
	
	/**
	 * 清除当前用户的登录状态信息
	 *
	 */
	public static function SetUserLogOut() {
		// 清除用户登录信息
		return setcookie( 'cm_mall_auth', '', null, '/', DZG_COOKIEDOMAIN );
	}
	
	public static function checkUseRegInfo($username, $password, $email) {
		if ($username == '') {
			return array(-2, '用户名不能为空');
		}
		try {
			cm_member::objects()->get("member_name = '$username'");
			return array(-3, '用户名已存在');
		} catch (DZGException $e) {
			
		}
		try {
			cm_member::objects()->get("member_email = '$email'");
			return array(-4, '该邮箱已被注册');
		} catch (DZGException $e) {
		}
		return array(1, '可以注册');
	}
	
}