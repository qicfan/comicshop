<?php
/**
 * 文章
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
		
class articleViews {	
	/**
	 * 文章列表页
	 */
	public static function articleList() {
		$page = intval( $_GET['page'] );
		$type = intval( $_GET['sort'] );
		$array = other::getArticleList($page, 10, $type);
		$tree1 = other::getArticleTree();
		$tree2 = other::getArticleTree2();
		$navigation = NAV_MY . '> <a>文章</a>';
		$array['tree1'] = $tree1;
		$array['tree2'] = $tree2;
		$array['navigation'] = $navigation;
		template('list', $array, 'default/front/article');
	}
	
	public static function articleShow() {
		template('show', $array, 'default/front/article');
	}
}