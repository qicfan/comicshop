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

class tongjiViews {	
	/**
	 * 资金明细统计
	 */
	public static function money() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$year = isset($_POST['year']) ? intval($_POST['year']) : date('Y',time()); 
		$amount = self::getMoney();
		$yearMoney = 0;
		for ($i = 0; $i < 12; $i++) {
			$stime = strtotime("$year-$i-01 00:00:00");
			$etime = strtotime("$year-".($i+1)."-01 00:00:00");
			$money[$i] = self::getMoney("paytime >= $stime AND paytime < $etime");
			$yearMoney += $money[$i];
		}
		$str = '';
		for ($i = 0; $i < 12; $i++) {
			$line[$i]= empty($money[$i]) ? 0 : number_format($money[$i], 1);
			$str .= $line[$i] . ', ';
		}
		$str = rtrim($str, ', ');
		//图表
		$json1 = '{ "title": { "text": "' . $year . '" }, ';
		$json1 .= '"elements": [ { "type": "bar_3d", "values": [ ' . $str . ' ], "colour": "#D54C78" } ], ';
		$json1 .= '"y_axis": { "min": 0, "max": ' . max($line) . ', "steps": ' . max($line)/10 . ' }, ';
		$json1 .= '"x_axis": { "3d": 5, "colour": "#909090", "labels": [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ] } }';
		$_SESSION['OFC_JSON_1'] = $json1;
		$json2 = '{ "title": { "text": "' . $year . '" }, ';
		$json2 .= '"elements": [ { "type": "pie", "colours": [ "#d01f3c", "#356aa0", "#C79810" ], "alpha": 0.6, "border": 2, "values": [ ' . $str . ' ], "colour": "#D54C78" } ] } ';
		$_SESSION['OFC_JSON_2'] = $json2;
		
		template('money', array('amount'=>$amount, 'money'=>$money, 'line'=>$line, 
				'year'=>$year, 'yearMoney'=>$yearMoney), 'default/admin/tongji');
	}
	
	/**
	 * OFC图表
	 */
	public static function moneyJSON_1() {
		die($_SESSION['OFC_JSON_1']);
	}
	
	/**
	 * OFC图表
	 */
	public static function moneyJSON_2() {
		die($_SESSION['OFC_JSON_2']);
	}
	
	private static function getMoney( $where = '' ) {
		global $db;
		try {
			$sql = "SELECT SUM(pay) FROM orders WHERE orderstate = 3";
			if ( !empty($where) ) {
				$sql .= " AND $where";
			}
			$rs = $db->prepare($sql);
			$rs->execute();
			$amount = $rs->fetchColumn();
		} catch (DZGException $e) {
			$amount = 0;
		}
		return $amount;
	}
	
	/**
	 * 商品销售情况统计
	 */
	public static function goods() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$page = $_GET['page'];
		$sql = "SELECT SUM(goodscoutn) AS sum,goodsname,goods_sn,shoppirce ";
		$sql .= "FROM goodsorder WHERE goods_type = 0 GROUP BY goodsid ORDER BY SUM(goodscoutn) DESC";
		$join =	salebill::objects()->pageFilter('', '', 2, $sql);
		$page = new pagination($join, 10, $page);
		template('goods', array('page'=>$page), 'default/admin/tongji');
	}
	
	/**
	 * 商品人气统计
	 */
	public static function click() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$page = $_GET['page'];
		$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
		if ($sort == '1') {
			$order = "storecount DESC, viewcount DESC";
		} else if ($sort == '2') {
			$order = "commentcount DESC, viewcount DESC";
		} else {
			$order = "viewcount DESC, storecount DESC";
		}
		$sql = "SELECT * FROM goods ORDER BY $order";
		$join =	salebill::objects()->pageFilter('', '', 2, $sql);
		$page = new pagination($join, 10, $page);
		template('click', array('page'=>$page), 'default/admin/tongji');
	}
	
	/**
	 * 在线支付统计
	 */
	public static function pay() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		core::redirect('正在进入漫域网在线支付系统......', 'http://pay.hapcomic.com/index.php/tongji?act=mall');
	}
	
	/**
	 * 用户统计
	 */
	public static function user() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$page = $_GET['page'];
		$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
		if ($sort == '1') {
			$order = "SUM(pay) DESC, COUNT(id) DESC";
		} else {
			$order = "COUNT(id) DESC, SUM(pay) DESC";
		}
		$sql = "SELECT COUNT(id) as count, SUM(pay) as sum, uid ";
		$sql .= "FROM orders WHERE orderstate = 3 GROUP BY uid ORDER BY $order";
		$join =	salebill::objects()->pageFilter('', '', 2, $sql);
		$page = new pagination($join, 10, $page);
		template('user', array('page'=>$page), 'default/admin/tongji');
	}
}