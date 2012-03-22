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
require_once PRO_ROOT . 'include/goods.class.php';
require_once PRO_ROOT . 'include/supply.class.php';
require_once PRO_ROOT . 'include/orderFun.class.php';
require_once PRO_ROOT . 'include/other.class.php';

class stockViews {
	/**
	 * 商品入库
	 */
	public static function goodsIn() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(91);
		$id = intval( $_GET['id'] );
		if ( !empty($id) ) {  //编辑信息的情况
			$info = Ware::GetOne($id);
			$price = Ware::getMemberPrice($id);
			$goodsBrand = Ware::getGoodsBrand($id);
			foreach ($goodsBrand as $i=>$v) {
				$goodsBrand[$i] = $v->bid;  //将商品的品牌ID放入数据
			}
		}
		//显示表单网页
		if ( !count($_POST) ) {			
			$brand = Ware::getBrand();
			$producer = supply::getProducer();
			$supply = supply::getSupply();
			$member = other::getMember();
			template('goodsIn', array('brand'=>$brand, 'goodsBrand'=>$goodsBrand, 'producer'=>$producer, 'supply'=>$supply, 'member'=>$member, 'info'=>$info, 'price'=>$price), 'default/admin/stock');
		}
		//数据处理
		$goodsname = htmlspecialchars( $_POST['goodsname'], ENT_QUOTES );
		$goods_sn = htmlspecialchars( $_POST['goods_sn'], ENT_QUOTES );
		$brand = $_POST['brand'];  //品牌是数组
		$producer = intval( $_POST['producer'] );
		$supply = intval( $_POST['supply'] );		
		if ( !empty($id) ) {
			$stock = $info->stock;  //编辑时不可以更新库存数量
		} else {
			$stock = intval( $_POST['stock'] );
		}
		$unit = htmlspecialchars( $_POST['unit'], ENT_QUOTES );
		$inprice = floatval( $_POST['inprice'] );
		$marketprice = floatval( $_POST['marketprice'] );
		$shopprice = floatval( $_POST['shopprice'] );
		$userprice = $_POST['userprice'];
		$autoonsale = intval( $_POST['autoonsale'] );
			
		if (empty($goodsname) || empty($goods_sn) || empty($brand) || empty($inprice) || empty($marketprice) || empty($shopprice)) {
			core::alert('信息填写有误！');
		}
		if ($stock < 0 || $autoonsale > 1 || $autoonsale < 0) {
			core::alert('信息填写有误！');
		}
		
		/* No Use
		$producer2 = htmlspecialchars( $_POST['producer2'], ENT_QUOTES );
		$supply2 = htmlspecialchars( $_POST['supply2'], ENT_QUOTES );
		
		if ( !empty($producer2) ) {  //新增生产商
			supply::setProducer('', $producer2);
			$producer = base::getInsertId();
		}
		if ( !empty($supply2) ) {  //新增供货商
			supply::setSupply('', $supply2, '');
			$supply = base::getInsertId();
		}
		*/

		//添加之前先检查商品编号和商品名称是否存在
		if ($id) {
			$checkflag = Ware::CheckGoodsName($id,$goodsname);
			if($checkflag) {
				core::alert("商品名称已经存在，请重新填写！");
			}
			$snflag = Ware::CheckGoods_sn($id,$goods_sn);
			if($snflag) {
				core::alert("商品编号已经存在，请重新填写！");
			}
		} else {
			$checkflag = Ware::GetGoodsByName($goodsname);
			if($checkflag) {
				core::alert("商品名称已经存在，请重新填写！");
			}
			
			$snflag = Ware::GetByGoods_sn($goods_sn);
			if($snflag) {
				core::alert("商品编号已经存在，请重新填写！");
			}
		}
		//写入数据库
		$rs = Ware::Add( $id, $goods_sn, $goodsname, $shopprice, $marketprice, $stock, $supply, $producer, $inprice, $autoonsale, $unit );
		//写入会员价
		if ( !empty($id) ) {
			$gid = $id;
		} else {
			$gid = base::getInsertId();
		}
		//商品品牌写入数据库
		$brandInfo = $brand;
		if (!empty($gid) && !empty($brandInfo)) {
			Ware::addGoodsBrand($gid, $brandInfo);
		}
		
		//会员价写入数据库
		$priceInfo = $price;
		if (!empty($gid) && !empty($userprice)) {
			$mid = $_POST['mid'];
			foreach ($userprice as $i=>$v) {
				$price = new goodsmemberprice();
				if ( !empty($priceInfo) ) {
					$price->id = $priceInfo[$i]->id;  //如果已有信息，那么是更新
				}
				$price->goodsid = $gid;
				if (empty($v) || empty($mid[$i])) {
					continue;
				}
				$price->mid = $mid[$i];
				$price->mprice = $v;
				$price->save();
			}
		}
		
		if ($rs) {
			if ( !empty($id) ) {
				base::setAdminLog('修改商品：'.$goodsname);
			} else {
				base::setAdminLog('商品入库：'.$goodsname);
			}
			core::alert('操作成功！');
		} else {
			core::alert('操作失败！');
		}
	}
	
	/**
	 * 添加标签Ajax
	 */
	public static function ajaxAddBrand() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(91);
		$dao = new brand();
		$dao->bname = $_POST['brand'];
		$dao->save();
		die($dao->id);
	}
	
	/**
	 * 库存列表
	 */
	public static function stockList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(91);
		//关键字搜索
		$type = $_POST['type'];
		$keyword = htmlspecialchars( $_POST['keyword'], ENT_QUOTES );
		if ( empty($keyword) ) {
			$manager = Ware::GetAll();
		} else if ($type == 'goodsname') {
			$manager = Ware::GetByName($keyword);
		}else if ($type == 'goods_sn') {
			$manager = Ware::GetBySN($keyword);
		}
		//分页
		$page = intval( $_GET['page'] );
		$page = new pagination($manager, 10, $page);
		template('stockList', array('page'=>$page), 'default/admin/stock');
	}
	
	/**
	 * 库存商品补货
	 */
	public static function stockMod() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(91);
		$gid = intval( $_POST['gid'] );
		$amount = intval( $_POST['amount'] );
		$amount = empty($amount) ? 0 : $amount;
		if ( empty($gid) ) {
			core::alert('无效的库存信息！');
			exit();
		}
		$goods = new goods();
		$goods->id = $gid;
		$goods->leavingcount = $amount;
		if ( $goods->save() ) {
			base::setAdminLog('库存补货：'.base::getGoodsName($gid));
			core::alert('补货成功！');
		} else {
			core::alert('补货失败！');
		}
	}
	
	/**
	 * 库存预警
	 */
	public static function stockWarn() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(91);
		$amount = intval( $_REQUEST['amount'] );
		$amount = empty($amount) ? 0 : $amount;

		$page = intval( $_GET['page'] );
		$manager = goods::objects()->pageFilter("leavingcount <= $amount");
		$page = new pagination($manager, 10, $page);  //分页
		template('stockWarn', array('page'=>$page), 'default/admin/stock');
	}
	
	/**
	 * 填写出库单
	 */
	public static function salebillEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(93);
		//可以用get/post方式传过来orderID，会自动填写orderSN
		$oid = intval( $_REQUEST['oid'] );
		try{
			$order = orders::objects()->get("id = $oid");
		}catch (Exception $e) {
			$order = false;
		}
		try{
			$logistics = logistics::objects()->all();
		}catch (Exception $e) {
			$logistics = false;
		}
		if ( !count($_POST) ) {
			template('salebillEdit', array('order'=>$order, 'logistics'=>$logistics), 'default/admin/stock');
		}
		
		//生成发货单
		if ( empty($order) ) {
			core::alert('订单编号错误');
		}
		if ( $order->poststate == '2' ) {
			core::alert('商品已发货');
		}
		try{
			salebill::objects()->get("oid = $oid");
			core::alert('发货单已存在');
		}catch (Exception $e) {
		}
		
		$lid = intval( $_POST['lid'] );
		$express = htmlspecialchars( $_POST['express'] );
		$time = time();
		$rand = rand(1000, 9999);
		$iid = date('YmdHis', $time) . $rand;  //流水号
		
		$bill = new salebill();
		$bill->oid = $oid;
		$bill->iid = $iid;
		$bill->billtime = $time;
		$bill->lid = $lid;
		$bill->express = $express;
		if ( $bill->save() ) {
			orderFun::updateOrderPoststate($oid, 1);  //修改订单状态
			base::setAdminLog('生成发货单：'.$iid);
			base::autoSkip('操作成功！', '发货单流水号：' . $iid, URL . 'index.php/admin/stock/salebillList');
		} else {
			core::alert('生成失败');
		}
	}
	
	/**
	 * 查看出库单/发货
	 */
	public static function salebillShow() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(94);
		$name = AdminAuth::GetAdminName();
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			core::alert('非法操作');
		}
		$bill = supply::getSalebill($id);
		if ( empty($bill) ) {
			core::alert('无此发货单');
		}
		$order = supply::getOrder($bill->oid);
		$goods = supply::getGoodsOrder($order->id);
		if ( !count($_POST) ) {								
			template('salebillShow', array('bill'=>$bill, 'order'=>$order, 'goods'=>$goods, 'name'=>$name), 'default/admin/stock');
		}
		
		//发货
		$remark = htmlspecialchars($_POST['remark'], ENT_QUOTES);
		$salebill = new salebill();
		$salebill->id = $id;
		$salebill->uid = AdminAuth::GetAdminId();
		$salebill->remark = $remark;
		$salebill->outtime = time();
		$salebill->state = 1;
		$rs = $salebill->save();
		//扣除库存余量
		foreach ($goods as $v) {
			Ware::goodsOut($v->goodsid, $v->goodscoutn);		
		}
		//更新订单的状态
		orderFun::updateOrderPoststate($order->id, 2);
		
		if ( $rs ) {
			base::setAdminLog('发货：'.$bill->iid);
			core::alert('发货成功');
		} else {
			core::alert('发货失败');
		}
	}
	
	/**
	 * 出库单管理
	 */
	public static function salebillList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(94);
		
		//关键字搜索
		$type = $_REQUEST['type'];
		$state = $_REQUEST['state'];
		$keyword = htmlspecialchars( $_POST['keyword'], ENT_QUOTES );
		//关键字搜索
		if ( empty($keyword) ) {
			$where = '1=1';
		} else if ($type == 'iid') {
			$where = "salebill.iid like '%$keyword%'";
		} else if ($type == 'order') {
			$where = "orders.order_sn like '%$keyword%'";
		} else if ($type == 'user') {
			$where = "orders.consignee like '%$keyword%'";
		} else {
			$where = '1=1';
		}
		//发货单状态筛选
		if ( $state == '1' || $state == '0') {
			if ( !empty($where) ) {
				$where .= ' AND ';
			}
			$where .= "salebill.state = $state";
		}		
		//连接查询并分页
		$page = intval( $_GET['page'] );
		$sql = "SELECT salebill.*, orders.order_sn, orders.consignee, orders.tel ";
		$sql .= "FROM salebill LEFT JOIN orders on salebill.oid = orders.id WHERE " . $where;
		$sql .= " ORDER BY salebill.id ";
		if ( empty($_GET['asc']) ) {
			 $sql .= "DESC";
		}
		$join =	salebill::objects()->pageFilter('', '', 2, $sql);
		$page = new pagination($join, 10, $page);
		
		template('salebillList', array('page'=>$page), 'default/admin/stock');
	}
	
	/**
	 * 删除出库单
	 */
	public static function salebillDel() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(9);
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			core::alert('非法操作');
			exit();
		}
		$bill = new salebill();
		$bill->id = $id;
		if ( $bill->delete() ) {
			base::setAdminLog('删除发货单：'.$id);
			core::alert('删除成功');
		} else {
			core::alert('删除失败');
		}
	}
	
	/**
	 * 物流商管理
	 */
	public static function logistics() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(9);
		$act = $_GET['act'];
		if ( !count($act) ) {
			$page = intval( $_GET['page'] );
			$manager = logistics::objects()->pageFilter($where, 'id');
			$page = new pagination($manager, 10, $page);  //分页
			template('logistics', array('page'=>$page), 'default/admin/stock');
		}
			
		//分类处理
		if ($act == 'del') {
			//删除
			$id = intval( $_GET['id'] );			
			if ( !empty($id) ) {
				$sort = new logistics();
				$sort->id = $id;
				$sort->delete();
				base::setAdminLog('删除物流商');
				core::redirect("删除成功", URL . "index.php/admin/stock/logistics");
			}
						
		} else if ($act == 'edit') {
			//编辑
			$id = $_POST['id'];
			$name = $_POST['name'];
			if (empty($id) || empty($name)){
				die();
			}
			$sort = new logistics();
			$sort->id = $id;
			$sort->lname = $name;
			$sort->save();
			base::setAdminLog('修改物流商');
			die();  //因为是Ajax的
			
		} else if ($act == 'add') {
			//添加
			$sort = new logistics();
			$name = $_POST['name'];
			if ( empty($name) ) {
				core::alert('请输入名称');
				exit();
			}
			$sort->lname = $name;
			$sort->save();
			base::setAdminLog('添加物流商');
			core::redirect("添加成功", URL . "index.php/admin/stock/logistics");
			
		} else {
			//nothing
		}
	}
}