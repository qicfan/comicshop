<?php
/**
 * 供货商管理
 * @author wj45
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/supply.class.php';

class supplyViews {
	/**
	 * 供货商列表（供货商管理）
	 */
	public static function supplyList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(10);
		$page = intval( $_GET['page'] );
		$manager = suppliers::objects()->pageFilter();
		$page = new pagination($manager, 10, $page);  //分页
		template('supplyList', array('page'=>$page), 'default/admin/supply');
	}
	
	/**
	 * 编辑供货商信息（供货商管理）
	 */
	public static function supplyEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(10);
		$id = intval( $_REQUEST['id'] );
		$name = htmlspecialchars($_REQUEST['name'], ENT_QUOTES);
		$des = htmlspecialchars($_REQUEST['des'], ENT_QUOTES);
		$addr = htmlspecialchars($_REQUEST['addr'], ENT_QUOTES);
		$con_way = htmlspecialchars($_REQUEST['con_way'], ENT_QUOTES);
		$con_man = htmlspecialchars($_REQUEST['con_man'], ENT_QUOTES);
		if ( !empty($id) ) {
			try {
				$supply = suppliers::objects()->get("id = $id");
			} catch (Exception $e) {
			}
		}
		if ( empty($name) || empty($des) ) {
			template('supplyEdit', array('supply'=>$supply, 'id'=>$id), 'default/admin/supply');
		}
		if ( supply::setSupply($id, $name, $addr, $con_way, $con_man, $des) ) {
			base::setAdminLog('编辑供货商信息');
			core::redirect("操作成功，正在跳转", URL . "index.php/admin/supply/supplyList");
		} else {
			core::alert('操作失败');
		}
	}
	
	/**
	 * 删除供货商列表（供货商管理）
	 */
	public static function supplyDelete() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(10);
		$id = intval( $_GET['id'] );
		if ( supply::clearSupply($id) ) {
			base::setAdminLog('删除供货商');
			core::alert('删除成功');
		} else {
			core::alert('删除失败');
		}
	}
	
	/**
	 * 生产商管理
	 */
	public static function producer() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(10);
		$act = $_GET['act'];
		if ( !count($act) ) {
			$page = intval( $_GET['page'] );
			$manager = producer::objects()->pageFilter($where, 'id');
			$page = new pagination($manager, 10, $page);  //分页
			template('producer', array('page'=>$page), 'default/admin/supply');
		}
			
		//分类处理
		if ($act == 'del') {
			//删除
			$id = intval( $_GET['id'] );			
			if ( !empty($id) ) {
				$sort = new producer();
				$sort->id = $id;
				$sort->delete();
				base::setAdminLog('删除生产商');
				core::redirect("删除成功", URL . "index.php/admin/supply/producer");
			}
						
		} else if ($act == 'edit') {
			//编辑
			$id = $_POST['id'];
			$name = $_POST['name'];
			if (empty($id) || empty($name)){
				die();
			}
			$sort = new producer();
			$sort->id = $id;
			$sort->pname = $name;			
			$sort->save();
			base::setAdminLog('修改生产商');
			die();  //因为是Ajax的
			
		} else if ($act == 'add') {
			//添加
			$sort = new producer();
			$name = $_POST['name'];
			if ( empty($name) ) {
				core::alert('请输入名称');
				exit();
			}
			$sort->pname = $name;
			$sort->save();
			base::setAdminLog('添加生产商');
			core::redirect("添加成功", URL . "index.php/admin/supply/producer");
			
		} else {
			//nothing
		}
	}
}