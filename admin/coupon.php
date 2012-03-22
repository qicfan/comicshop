<?php
/**
 * 优惠券系统
 * @author wj45
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
class couponViews {
	/**
	 * 列出所有的优惠券（管理员，权限ID为4）
	 */
	public static function couponList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(4);
		$page = intval( $_GET['page'] );
		$type = intval( $_GET['type'] );
		if ($type != 1){
			$time = time();
			$where = "deadline > $time";
		}
		$manager = coupon::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, 10, $page);  //分页
		template("couponList", array('page'=>$page, 'type'=>$type), 'default/admin/coupon');
	}
	
	/**
	 * 编辑要生成的优惠券（管理员）
	 */
	public static function couponEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(4);
		template("couponEdit", array('sort'=>$sort), 'default/admin/coupon');
	}
	
	/**
	 * 批量生成优惠券（Ajax）（管理员）
	 */
	public static function couponProduce() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(4);
		base::checkRefresh();
		$amount = intval( $_POST['amount'] );
		$fee = intval( $_POST['fee'] );  //优惠金额的单位是元，而且必须是整数
		$startTime = $_POST['startTime'];
		$deadLine = $_POST['deadLine'];
		if ($amount < 1 || $amount > 9999 || $fee < 1 || empty($deadLine)){  //一次最多生成一万张
			die('0');
		}
		$startTime = empty($startTime) ? date('Y-m-d H:i:s',time()) : $startTime;
		if ($startTime > $deadLine) {
			die('0');  //生效日期必须在失效日期之前
		}
		$date = date('ymdhis', time());
		for ($i = 0; $i < $amount; $i++) {
			$num = (($i + 1) / 10000);
			$num = number_format($num, 4);  //保留4位小数
			$num = str_replace('0.', '',  $num);  //补齐前面的0
			$code = 'MC-' . $date . '-' . $num;  //编号
			//写入数据库
			other::addCoupon($code, $fee, strtotime($startTime), strtotime($deadLine));
		}
		base::setAdminLog('批量生成优惠券');  //记录管理员操作
		die('1');
	}
	
}