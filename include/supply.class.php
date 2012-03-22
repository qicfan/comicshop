<?php
/**
 * 供货商/生产商 库存管理
 * @author wj45
 */
class supply {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}
	
	/**
	 * 保存供货商数据到数据库（供货商管理）
	 */
	public static function setSupply($id, $name, $addr, $con_way, $con_man, $des) {
		$supply = new suppliers();
		if ( !empty($id) ) {
			$supply->id = $id;
		}
		$supply->suppliername = $name;
		$supply->addr = $addr;
		$supply->con_way = $con_way;
		$supply->con_man = $con_man;
		$supply->des = $des;
		$rs = $supply->save();
		return $rs;
	}
	
	/**
	 * 获取所有供应商信息（供货商管理）
	 */
	public static function getSupply() {
		try {
			$supply = suppliers::objects()->all();
		} catch (Exception $e) {
			$supply = false;
		}
		return $supply;
	}
	
	/**
	 * 删除供货商数据（供货商管理）
	 */
	public static function clearSupply( $id ) {
		$supply = new suppliers();
		$supply->id = $id;
		$rs = $supply->delete();
		return $rs;
	}
	
	/**
	 * 通过商品ID得到供货商名称（库存管理）
	 */
	public static function getSupplyName( $id ) {
		try {
			$supply = suppliers::objects()->get("id = $id");
			$supply = $supply->suppliername;
		} catch (Exception $e) {
			$supply = false;
		}
		return $supply;
	}
	
	/**
	 * 通过ID得到物流商名称
	 */
	public static function getLogisticsName( $id ) {
		try {
			$supply = logistics::objects()->get("id = $id");
			$supply = $supply->lname;
		} catch (Exception $e) {
			$supply = false;
		}
		return $supply;
	}
	
	/**
	 * 获得商品的全部生产商
	 */
	public static function getProducer() {
		try {
			$producer = producer::objects()->all();
		} catch (Exception $e) {
			$producer = false;
		}
		return $producer;
	}
	
	/**
	 * 插入或更新生产商信息
	 */
	public static function setProducer($id, $name) {
		$producer = new producer();
		if ( !empty($id) ) {
			$producer->id = $id;
		}
		$producer->pname = $name;
		$rs = $producer->save();
		return $rs;
	}
	
	/**
	 * 取得出库单信息
	 */
	public static function getSalebill( $id ) {
		try {
			$order = salebill::objects()->get("id = $id");
		} catch (Exception $e) {
			$order = false;
		}
		return $order;
	}
	
	/**
	 * 取一个订单的信息
	 */
	public static function getOrder( $id ) {
		try {
			$order = orders::objects()->get("id = $id");
		} catch (Exception $e) {
			$order = false;
		}
		return $order;
	}
	
	/**
	 * 取一个订单的商品信息
	 */
	public static function getGoodsOrder( $id ) {
		try {
			$order = goodsorder::objects()->filter("orderid = $id");
		} catch (Exception $e) {
			$order = false;
		}
		return $order;
	}
	
	/**
	 * 获得派送方式的名称
	 */
	public static function getPostType( $id ) {
		switch ($id) {
			case 0:
				$name = '自提';
				break;
			case 1:
				$name = '快递';
				break;
			case 2:
				$name = 'EMS';
				break;
			default:
				$name = '';
		}
		return $name;
	}
	
	/**
	 * 获得派送方式的名称
	 */
	public static function getBillState( $id ) {
		switch ($id) {
			case 0:
				$name = '未发货';
				break;
			case 1:
				$name = '已发货';
				break;
			default:
				$name = '';
		}
		return $name;
	}
	
	/**
	 * 获得派送方式的名称
	 */
	public static function getBestTime( $id ) {
		switch ($id) {
			case 0:
				$name = '不限';
				break;
			case 1:
				$name = '周一至周五';
				break;
			case 3:
				$name = '周末';
				break;
			default:
				$name = '不限';
		}
		return $name;
	}
	
	/**
	 * 取得代发货的发货单总数
	 */
	public static function getBillCount() {
		global $db;
		try {
			$sql = "SELECT COUNT(*) AS count FROM salebill WHERE state = 0";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchAll();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = false;
		}
		return $count[0][0];
	}
	
	/*
	 * 检查有没有供货商，根据名称
	*/
	public static function CheckSupplier($sname){
		try{
			return suppliers::objects()->get("suppliername='".$sname."'");
		}catch(DZGException $e){
			return false;
		}
	}
}
?>