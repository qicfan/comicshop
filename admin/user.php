<?php
/**
 * 会员管理系统
 * @author wj45
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/userFun.class.php';

class userViews {
	/**
	 * 会员列表
	 */
	public static function userList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$page = intval( $_GET['page'] );
		$manager = user::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, 10, $page);  //分页
		template('userList', array('page'=>$page), 'default/admin/user');
	}
	
	/**
	 * 显示用户详情
	 */
	public static function userShow() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$id = intval( $_GET['id'] );
		$uid = intval( $_GET['uid'] );
		$act = intval( $_GET['act'] );
		try {
			$info = user::objects()->get("id = $id");
		} catch (Exception $e) {
		}
		switch ($act) {
			case 1:
				$detail = userFun::getUserCart($uid);
				break;
			case 2:
				$detail = userFun::getUserCollect($uid);
				break;
			case 3:
				$detail = userFun::getUserOrders($uid);
				break;
			default:
				$detail = '';
		}
		$score = userFun::getUserScore($id);
		template('userShow', array('info'=>$info, 'id'=>$id, 'act'=>$act, 'score'=>$score, 'detail'=>$detail), 'default/admin/user');
	}
	
	/**
	 * 编辑会员信息
	 */
	public static function userEdit() {
		//新增会员需要调用漫域通行证的接口，到时还要再修改
		
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$id = intval( $_GET['id'] );
		if ( !count($_POST) ) {
			if ( !empty($id) ) {
				try {
					$info = user::objects()->get("id = $id");
				} catch (Exception $e) {
				}
			}
			try {
				$member = member::objects()->all();
			} catch (Exception $e) {
			}
			template('userEdit', array('info'=>$info, 'member'=>$member, 'id'=>$id), 'default/admin/user');
		}
		if ( empty($id) ) {
			$uname = htmlspecialchars( $_POST['uname'], ENT_QUOTES );
		}
		$member = intval( $_POST['member'] );
		$mobile = htmlspecialchars( $_POST['mobile'], ENT_QUOTES );
		$address = htmlspecialchars( $_POST['address'], ENT_QUOTES );
		$email = htmlspecialchars( $_POST['email'], ENT_QUOTES );
		
		if ((empty($id) && empty($uname)) || empty($member)) {
			core::alert('信息填写有误');
		}
		//写入数据库
		$rs = userFun::addUser( $id, $uname, $member, $mobile, $address, $email );
		if ( $rs ) {
			base::setAdminLog('编辑会员信息');
			base::autoSkip('操作成功', '查看全部会员', URL . "index.php/admin/user/userList");
		} else {
			core::alert('操作失败');
		}
	}
	
	/**
	 * 删除会员
	 */
	public static function userDel() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			core::alert('操作失败');
		}
		$user = new user();
		$user->id = $id;
		if ( $user->delete() ) {
			base::setAdminLog('编辑会员');
			core::alert('删除成功');
		} else {
			core::alert('删除失败');
		}
	}
	
	/**
	 * 会员等级列表
	 */
	public static function memberList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$page = intval( $_GET['page'] );
		$manager = member::objects()->pageFilter($where, 'id');
		$page = new pagination($manager, 10, $page);  //分页
		template('memberList', array('page'=>$page), 'default/admin/user');
	}
	
	/**
	 * 编辑会员等级
	 */
	public static function memberEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$id = intval( $_GET['id'] );
		if ( !count($_POST) ) {
			if ( !empty($id) ) {
				try {
					$info = member::objects()->get("id = $id");
				} catch (Exception $e) {
				}
			}
			template('memberEdit', array('info'=>$info, 'id'=>$id), 'default/admin/user');
		}
		
		$mname = htmlspecialchars( $_POST['mname'], ENT_QUOTES );
		$level = intval( $_POST['level'] );
		$ratio = floatval( $_POST['ratio'] );
		$des = htmlspecialchars( $_POST['des'], ENT_QUOTES );
		
		if (empty($mname) || $level < 0 || $ratio > 1 || $ratio <= 0) {
			core::alert('信息填写有误');
		}
		
		$member = new member();
		if ( !empty($id) ) {
			$member->id = $id;
		}
		$member->mname = $mname;
		$member->level = $level;
		$member->ratio = $ratio;
		$member->des = $des;
		if ( $member->save() ) {
			base::setAdminLog('编辑会员等级');
			base::autoSkip('操作成功', '查看全部会员等级', URL . "index.php/admin/user/memberList");
		} else {
			core::alert('操作失败');
		}
	}
	
	/**
	 * 删除会员等级
	 */
	public static function memberDel() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(12);
		
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			core::alert('操作失败');
		}
		$member = new member();
		$member->id = $id;
		if ( $member->delete() ) {
			base::setAdminLog('删除会员等级');
			core::alert('删除成功');
		} else {
			core::alert('删除失败');
		}
	}

	/**
	 *  检查会员名称是否注册
	 */
//	public static function nameCheck() {
//
//        $user_name = $_GET['user_name'];
//		//$user = new user();
//
//			try {
//				user::objects()->get("uname = '$user_name'");
//				
//			} catch (Exception $e) {
//
//					echo json_encode(array("0", "用户{$user_name}已存在。", $url));
//					exit();
//
//			}
//
//			echo json_encode(array("1", "用户{$user_name可以注册。", $url));
//
//	}


}