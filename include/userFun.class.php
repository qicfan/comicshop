<?php
/**
 * 用户方法类
 * @author wj45
 */
class userFun {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}
	
	/**
	 * 增加会员/更新会员信息，写入数据库
	 */
	public static function addUser( $id, $uname, $member, $mobile = '', $address = '', $email = '', $uid='' ) {
		$user = new user();
		if ( !empty($id) ) {
			$user->id = $id;
			
		} else {
			try {
				user::objects()->get("uname = '$uname'");
				core::alert('用户名已存在');
			} catch (Exception $e) {
			}
		}
        $user->uid = $uid;
		$user->uname = $uname;
		$user->member = $member;  //会员等级，member表中的ID
		$user->mobile = $mobile;
		$user->address = $address;
		$user->email = $email;
		$rs = $user->save();
		return $rs;
	}

	/*
	*  通过id获取用户信息 
	*/

	public static function getUserInfoById($uid){

			return user::objects()->get("uid = $uid");

	}

	/**
	 * 获取会员的积分
	 */
	public static function getUserScore( $uid ) {
		try {
			$score = integral::objects()->get("uid = $uid");
			$score = $score->score;
		} catch (Exception $e) {
			$score = false;
		}
		return $score;
	}
	
	/**
	 * 通过ID获取会员的购物车信息（分页）
	 */
	public static function getUserCart( $uid, $size = 10 ) {
		$page = intval( $_GET['page'] );
		$manager = cart::objects()->pageFilter("uid = $uid", 'id DESC');
		$page = new pagination($manager, $size, $page);  //分页
		return $page;
	}
	
	/**
	 * 通过ID获取会员的收藏信息（分页）
	 */
	public static function getUserCollect( $uid, $size = 10 ) {
		$page = intval( $_GET['page'] );
		$manager = collect::objects()->pageFilter("uid = $uid", 'id DESC');
		$page = new pagination($manager, $size, $page);  //分页
		return $page;
	}
	
	/**
	 * 通过ID获取会员的订单信息（分页）
	 */
	public static function getUserOrders( $uid, $size = 10 ) {
		$page = intval( $_GET['page'] );
		$manager = orders::objects()->pageFilter("uid = $uid", 'id DESC');
		$page = new pagination($manager, $size, $page);  //分页
		return $page;
	}
	
	/*
	 * 获取标题行
	*/
	public static function GetHeadLine(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$str = '';
	  	if (auth::isUserLogin() == true) {
	  		$str .= "<span>您好：".auth::getUserName()."</span><span class='out_login fn_hs'>[<a href='".GoodsFront::GetUrl('myindex')."'>个人中心</a>] | [<a href='".URL."index.php/front/user/userLogout'>退出登录</a>]</span>";
	 	} else {
	 		$str .= "<span class='out_login fn_hs'>[<a href='".GoodsFront::GetUrl('login')."'>登录</a>] | [<a href='".GoodsFront::GetUrl('reg')."'>注册</a>]</span>";
	  	}
	  	return $str;
	}

}
?>