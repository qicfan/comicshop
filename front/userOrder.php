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
		
class userOrderViews {	
	/**
	 * 显示订单列表
	 */
	public static function orderList() {
		auth::authUser();
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		$where = "uid = $uid";
		$sort = $_GET['sort'];
		$time = time() - 3600 * 24 * 30;  //一个月前的时间戳
		if ($sort == 'past') {  //一个月前的
			$where .= " AND createtime < $time";
			$tab['t2'] = true;
		}else if ($sort == 'ab') {  //取消的
			$where .= " AND (orderstate = 2 OR orderstate = 0)";
			$tab['t5'] = true;
		} else if ($sort == 'done') {  //完成的
			$where .= " AND orderstate = 3";
			$tab['t4'] = true;
		} else if ($sort == 'wp') {  //等待付款的
			$where .= " AND paystate = 0";
			$tab['t3'] = true;
		} else if ($sort == 'all')  {
			$tab['t6'] = true;
		} else {
			$where .= " AND createtime > $time";  //近一个月的
			$tab['t1'] = true;
		}
		//计算订单数量
		$count['t1'] = self::getCount("uid = $uid AND createtime > $time");
		$count['t2'] = self::getCount("uid = $uid AND createtime < $time");
		$count['t3'] = self::getCount("uid = $uid AND paystate = 0");
		$count['t4'] = self::getCount("uid = $uid AND orderstate = 3");
		$count['t5'] = self::getCount("uid = $uid AND orderstate = 2");
		$count['t6'] = self::getCount("uid = $uid");
		
		$page = intval($_GET['page']);
		$manager = orders::objects()->pageFilter($where, 'createtime DESC');  //按下单时间倒序排列
		$page = new pagination($manager, PAGE_SIZE, $page);  //分页
		$navigation = NAV_MY . '> <a>我的订单</a>';
		template('orderList', array('page'=>$page, 'sort'=>$sort, 'tab'=>$tab, 'count'=>$count, 'navigation'=>$navigation, 'uname'=>$uname), 'default/front/userOrder');
	}
	
	/**
	 * 订单详情
	 */
	public static function orderDetail() {
		auth::authUser();
		$id = intval( $_GET['id'] );
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		try{
			$order = orders::objects()->get("id = $id");
		}catch (Exception $e) {
			core::alert('无此订单');
		}
		//不允许查看别人的订单
		if ($uid != $order->uid) {
			die('非法操作');
		}
		$goods = supply::getGoodsOrder($order->id);
		$navigation = NAV_MY . '> <a>订单详情</a>';
		template('orderDetail', array('order'=>$order, 'goods'=>$goods, 'navigation'=>$navigation, 'uname'=>$uname), 'default/front/userOrder');
	}
	
	private static function getCount($where = '1=1') {
		global $db;
		try {
			$sql = "SELECT COUNT(id) FROM orders WHERE ";
			$sql .= $where;
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchColumn();
		} catch (DZGException $e) {
			$count = 0;
		}
		return $count;
	}
}