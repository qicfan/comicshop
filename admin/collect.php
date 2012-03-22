<?php
/**
 * 收藏系统
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
class collectViews {
	/**
	 * 列出收藏列表统计情况（管理权限ID为9）
	 */
	public static function collectList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(9);
		$collect = other::getCollectAll();
		template('collectList', array('collect'=>$collect), 'default/admin/collect');
	}
}