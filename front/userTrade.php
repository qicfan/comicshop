<?php
/**
 * 用户的订单，我的订单
 * @author wj45
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/orderFun.class.php';
require_once PRO_ROOT . 'include/supply.class.php';
		
class userTradeViews {	
	/**
	 * 交易记录列表
	 */
	public static function tradeList() {
		auth::authUser();
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		$where = "payrecord.uid = $uid";
		$date = htmlspecialchars( $_REQUEST['date'], ENT_QUOTES );
		$sn = htmlspecialchars( $_REQUEST['sn'], ENT_QUOTES );
		$stime = strtotime($date . '00:00:00');
		$etime = strtotime($date . '23:59:59');
		if ( !empty($date) ) {
			$where .= " AND orders.createtime < $etime AND orders.createtime > $stime";
		}
		if ( !empty($sn) ) {
			$where .= " AND orders.order_sn like '$sn%'";
		}
		$page = intval($_GET['page']);
		$sql = "SELECT payrecord.*, orders.order_sn, orders.pay, orders.postfee, orders.createtime ";
		$sql .= "FROM payrecord LEFT JOIN orders on payrecord.orderid = orders.id WHERE " . $where;
		$sql .= " ORDER BY paytime DESC ";
		$join =	payrecord::objects()->pageFilter('', '', 2, $sql);
		$page = new pagination($join, PAGE_SIZE, $page);  //分页
		$navigation = NAV_MY . '> <a>交易记录</a>';
		template('tradeList', array('page'=>$page, 'date'=>$date, 'sn'=>$sn, 'navigation'=>$navigation, 'uname'=>$uname), 'default/front/userTrade');
	}
}