<?php
/**
 * 退款申请
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';

class aftersaleViews{
	/**
	 * 用户提交 举报
	 */
	public static function index() {
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新

		$type = htmlspecialchars( $_POST['type'], ENT_QUOTES );
		$reason = htmlspecialchars( $_POST['reason'], ENT_QUOTES );
		$remark = htmlspecialchars( $_POST['remark'], ENT_QUOTES );
		$oid = floatval( $_POST['oid']);
		$delivery = htmlspecialchars( $_POST['delivery'], ENT_QUOTES );
		$express = htmlspecialchars( $_POST['express'], ENT_QUOTES );
		$parcel = htmlspecialchars( $_POST['parcel'], ENT_QUOTES );
		$address =$_POST['address'];
		$zipcode = intval( $_GET['zipcode'] );
		$uid = auth::getUserId();
		$id = intval( $_GET['id'] );
		$province = intval($_POST['province']);
		$district = intval($_POST['district']);
		$city = $_POST['city'];
	
		if (empty($orderid) || empty($bankcard)) {
			$uname = auth::getUserName();
			$page = intval($_GET['page']);
			$manager = aftersale::objects()->pageFilter("uid = $uid", 'id DESC');  //按id倒序排列
			$aftersale = new pagination($manager, PAGE_SIZE, $page);  //分页
			$count=$aftersale->dataCount;
            $navigation = NAV_MY . '> <a>返修/退货</a>';
			template("refund", array('aftersale'=>$aftersale,'page'=>$page,'uname'=>$uname,'count'=>$count,'navigation'=>$navigation), 'default/front/refund');
			exit();
		}

		if ( strtoupper($seccode) != strtoupper($_SESSION['seccode']) ) {
			core::alert('验证码错误');
			exit();
		}

		$time = time();
		//数据库
		$refund = new refund();
							
		$refund->id = $id;
		$refund->uid = $uid;
		$refund->type = $type;
		$refund->oid = $oid;
		$refund->remark = $remark;
		$refund->reason = $reason;
		$refund->delivery = $delivery;
		$refund->express = $express;
		$refund->time = $time;
        $refund->parcel = $parcel;
		$refund->address = $address;
		$refund->zipcode = $zipcode;
		$refund->province = $province;
		$refund->city = $city;
		$refund->district = $district;
		$refund->state = 0;

		$rs = $refund->save();
		
		if ($rs){
			core::alert('提交成功！');
		}else {
			core::alert('提交失败！');
		}
		
	}

}
?>