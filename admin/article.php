<?php
/**
 * 文章系统
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
	public static function index() {
	}
	
	/**
	 * 显示文章列表（管理员，权限ID为2）
	 */
	public static function articleList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		
		$page = intval( $_GET['page'] );
		$type = intval( $_GET['sort'] );
		$array = other::getArticleList($page, 10, $type);
		$array['type'] = $type;
		
		template("articleList", $array , 'default/admin/article');
	}
	
	/**
	 * 编辑文章内容（管理员）
	 */
	public static function articleEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			template("articleEdit", array('sort'=>$sort), 'default/admin/article');
		} else {
			try {
				$article = article::objects()->get("id = $id");
			} catch (Exception $e) {
			}
			$content = base::getContent($article->createtime, 'article_'.$article->id);  //读取content内容
			template("articleEdit", array('article'=>$article, 'content'=>$content), 'default/admin/article');
		}
	}
	
	/**
	 * 发布或更新文章（管理员）
	 */
	public static function articleUpdate() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		base::checkRefresh();  //防刷新
		$id = intval($_POST['id']);
		$title = htmlspecialchars( $_POST['title'], ENT_QUOTES );
		$author = AdminAuth::GetAdminId();
		$sort = $_POST['sort'];
		$status = $_POST['status'];
		$content = $_POST['content'];
		if (empty($title) || empty($content)) {
			core::alert('内容不完整！');
			exit();
		}
		$time = time();
		//数据库
		$article = new article();
		if ( !empty($id) ) {
			$article->id = $id;  //如果有ID，那么是更新操作
		}
		$article->title = $title;
		$article->adminid = $author;
		$article->sort = $sort;
		$article->state = $status;
		$article->createtime = $time;
		$article->save();
		if ( empty($id) ) {  //如果没有ID，读出刚插入的自增ID
			$id = base::getInsertId();
		}	

		$rs = base::setContent($time, 'article_'.$id, $content);  //content保存为静态文件
		if ($rs) {
			self::makeHtml($id);  //顺便生成一下静态网页
			base::setAdminLog('编辑文章：' . $title);  //记录管理员操作
			base::autoSkip("发布成功，正在跳转", '', URL . "index.php/admin/article/articleList");
		} else {
			core::alert('发布失败！');
		}		
	}
	
	/**
	 * 删除文章，支持批量删除（Ajax）（管理员）
	 */
	public static function articleDelete() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		base::checkRefresh();  //防刷新
		$id = $_POST['id'];
		$id = trim($id, ',');
		$id = explode(',', $id);
		if (empty($id)) {
			core::alert('非法操作！');
			exit();
		}
		foreach ($id as $i=>$v) {
			if (empty($v)) {
				continue;
			}
			try {
				$articleInfo = article::objects()->get("id = $v");
			} catch (Exception $e) {
			}
			$article = new article;
			$article->id = $v;
			$article->delete();  //删除数据库数据
			base::clearContent($articleInfo->createtime, 'article_'.$articleInfo->id);  //删除静态文件
		}
		base::setAdminLog('删除文章');  //记录管理员操作
	}
	
	/**
	 * 显示文章
	 */
	public static function articleShow() {
		$id = intval( $_GET['id'] );
		$html = 'html/article/' . $id . '.html';
		if ( file_exists($html) ){  //如果有静态网页，那就直接跳转过去吧
			//core::redirect('', URL . $html);
		}
		try {
			$article = article::objects()->get("id = $id");
		} catch (Exception $e) {
			core::alert('无此文章！');
			exit();
		}
		try {
			$sort = articlecategory::objects()->get("id = '$article->sort'");
			$sort = $sort->sortname;  //获取分类名称
		} catch (Exception $e) {
			$sort = '';
		}
		$tree2 = other::getArticleTree2();
		$content = base::getContent($article->createtime, 'article_'.$article->id);  //读取content内容
		$navigation = NAV_MY . '> <a>文章</a>';
		template("articleShow", array('article'=>$article, 'content'=>$content, 'sort'=>$sort, 'tree2'=>$tree2, 'navigation'=>$navigation), 'default/admin/article');
	}
	
	/**
	 * 文章分类的管理（管理员）
	 */
	public static function articleSort() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		$act = $_GET['act'];
		if ( !count($act) ) {
			try {
				$id = intval( $_GET['sort'] );
				$sort = articlecategory::objects()->get("id = $id");  //获取分类名称
			} catch (Exception $e) {
				$sort = '';
			}
			template("articleSort", array('sort'=>$sort), 'default/admin/article');
		}
			
		//分类处理
		if ($act == 'del') {
			//删除
			$id = intval( $_GET['id'] );			
			if ( !empty($id) ) {
				$sort = new articlecategory();
				$sort->id = $id;
				$sort->delete();
				base::setAdminLog('删除文章分类');
				core::redirect("删除成功", URL . "index.php/admin/article/articleSort");
			}
						
		} else if ($act == 'edit') {
			//编辑
			$id = $_POST['id'];
			$name = $_POST['name'];
			if (empty($id) || empty($name)){
				die();
			}
			$sort = new articlecategory();
			$sort->id = $id;
			$sort->sortname = $name;
			$sort->save();
			base::setAdminLog('修改文章分类');
			die();  //因为是Ajax的
			
		} else if ($act == 'add') {
			//添加
			$sort = new articlecategory();
			$name = $_POST['name'];
			$pid = intval( $_POST['pid'] );
			if ( empty($name) || empty($pid)) {
				core::alert('请输入名称');
				exit();
			}
			$sort->sortname = $name;
			$sort->parentid = $pid;
			$sort->save();
			base::setAdminLog('添加文章分类');
			core::redirect("添加成功", URL . "index.php/admin/article/articleSort");
			
		} else {
			//nothing
		}
	}
	
	/**
	 * 批量生成静态网页/更新全部静态网页
	 */
	public static function makeAll() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		try {
			$all = article::objects()->all();
		} catch (Exception $e) {
		}
		foreach ($all as $i=>$v) {
			$id = $v->id;
			self::makeHtml($id);  //迭代
		}
	}
	
	/**
	 * 生成或更新静态网页
	 */
	private static function makeHtml( $id ) {
		//先从数据库中读取数据
		try {
			$article = article::objects()->get("id = $id");
		} catch (Exception $e) {
			$article = '';
		}
		try {
			$sort = articlecategory::objects()->get("id = '$article->sort'");
			$sort = $sort->sortname;  //获取分类名称
		} catch (Exception $e) {
			$sort = '';
		}
		$tree2 = other::getArticleTree2();
		$navigation = NAV_MY . '> <a>文章</a>';
		$content = base::getContent($article->createtime, 'article_'.$article->id);  //读取content内容
		$array = array('article'=>$article, 'content'=>$content, 'sort'=>$sort, 'tree2'=>$tree2, 'navigation'=>$navigation);
		//生成静态网页
		base::makeHtml("articleShow", $array, 'default/admin/article', 'html/article/'.$id.'.html');
	}
}