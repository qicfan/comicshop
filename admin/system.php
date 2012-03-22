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
require_once PRO_ROOT . 'include/other.class.php';

class systemViews {
	/**
	 * 友情链接列表（系统管理）
	 */
	public static function linkList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$link = other::getFriendLink();
		template('linkList', array('link'=>$link), 'default/admin/system');
	}
	
	/**
	 * 友情链接编辑（系统管理）
	 */
	public static function linkEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$id = intval( $_GET['id'] );
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
		$linkurl = htmlspecialchars($_POST['linkurl'], ENT_QUOTES);
		$sort = intval( $_POST['sort'] );
		if (empty($title) || empty($linkurl)) {
			try {
				$link = friendship::objects()->get("id = $id");
			} catch (Exception $e) {
			}
			template('linkEdit', array('link'=>$link, 'id'=>$id), 'default/admin/system');
		} else {
			//写入数据库
			$link = new friendship();
			if ( !empty($id) ) {
				$link->id = $id;  //有ID则是更新，没有则是插入
			}
			$link->title = $title;
			$link->linkurl = $linkurl;
			$link->sort = $sort;
			if ( $link->save() ) {
				base::setAdminLog('编辑友情链接');  //记录管理员操作
				core::redirect("操作成功，正在跳转", URL . "index.php/admin/system/linkList");
			} else {
				core::alert('操作失败');
			}
		}
	}
	
	/**
	 * 友情链接删除（系统管理）
	 */
	public static function linkDelete() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			core::alert('删除失败');
			exit();
		}
		$link = new friendship();
		$link->id = $id;
		if ( $link->delete() ) {
			base::setAdminLog('删除友情链接');  //记录管理员操作
			core::redirect("操作成功，正在跳转", URL . "index.php/admin/system/linkList");
		} else {
			core::alert('删除失败');
		}
	}
	
	/**
	 * 地区管理（系统管理）
	 */
	public static function regionList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$pid = intval( $_GET['id'] );
		$pid = empty($pid) ? 0 : $pid;
		$region = base::getRegion($pid);
		try {
			$parent = region::objects()->get("id = $pid");
			$level = $parent->region_type + 1;  //地区的级数
			$parent = $parent->parent_id;  //用于返回上一级			
		} catch (Exception $e) {
			$level = 0;
			$parent = 0;		
		}	
		template('regionList', array('region'=>$region, 'id'=>$pid, 'level'=>$level, 'parent'=>$parent), 'default/admin/system');
	}
	
	/**
	 * 地区编辑（系统管理）
	 */
	public static function regionSubmit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$act = $_GET['act'];
		//分类处理
		if ($act == 'add') {  //添加
			$level = intval( $_GET['lv'] );
			$pid = intval( $_GET['id'] );
			$name = htmlspecialchars($_POST['name'], ENT_QUOTES);
			if ( empty($name) ) {
				core::alert('请填写名称');
			}
			$level = empty($level) ? 0 : $level;
			$pid = empty($level) ? 0 : $pid;
			$region = new region();
			$region->parent_id = $pid;
			$region->region_name = $name;
			$region->region_type = $level;
			if ( $region->save() ) {
				core::alert('添加成功');
			} else {
				core::alert('添加失败');
			}
		} else if ($act == 'del') {  //删除
			$id = intval( $_GET['id'] );
			if ( empty($id) ) {
				die('非法操作');
			}
			$region = new region();
			$region->id = $id;
			if ( $region->delete() ) {
				core::alert('删除成功');
			} else {
				core::alert('删除失败');
			}
		} else if ($act == 'edit') {  //修改
			$id = intval( $_GET['id'] );
			$name = htmlspecialchars($_POST['name'], ENT_QUOTES);
			if ( empty($name) ) {
				core::alert('请填写名称');
			}
			$region = new region();
			$region->id = $id;
			$region->region_name = $name;
			if ( $region->save() ) {
				core::alert('修改成功');
			} else {
				core::alert('修改失败');
			}
		} else {
			die('非法操作');
		}
	}
	
	/**
	 * 验证码管理（系统管理）
	 */
	public static function codeEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		try {
			$code = authcode::objects()->get();
		} catch (Exception $e) {
			$code = '';
		}
		if (!count($_POST)) {
			template('codeEdit', array('code'=>$code), 'default/admin/system');
		}
		$isreg = intval( $_POST['isreg'] );
		$islogin = intval( $_POST['islogin'] );
		$isquestion = intval( $_POST['isquestion'] );
		$iscomment = intval( $_POST['iscomment'] );
		$isloginman = intval( $_POST['isloginman'] );
		$codewidth = intval( $_POST['codewidth'] );
		$codeheight = intval( $_POST['codeheight'] );
		$isreg = ($isreg == 1) ? 1 : '0';  //0或1，'0'需要加引号
		$islogin = ($islogin == 1) ? 1 : '0';
		$isquestion = ($isquestion == 1) ? 1 : '0';
		$iscomment = ($iscomment == 1) ? 1 : '0';
		$isloginman = ($isloginman == 1) ? 1 : '0';
		if ($codewidth > 300 || $codewidth < 20) {
			$codewidth = 90;  //默认长度
		}
		if ($codeheight > 150 || $codeheight < 10) {
			$codeheight = 20;  //默认宽度
		}
		//写入数据库
		$code = new authcode();
		$code->id = 1;  //只有一条数据
		$code->isreg = $isreg;
		$code->islogin = $islogin;
		$code->isquestion = $isquestion;
		$code->iscomment = $iscomment;
		$code->isloginman = $isloginman;
		$code->codewidth = $codewidth;
		$code->codeheight = $codeheight;
		if ( $code->save() ){
			base::setAdminLog('更改验证码设置');
			core::redirect("修改成功，正在跳转", URL . "index.php/admin/system/codeEdit");
		} else {
			core::alert('修改失败');
		}
	}
	
	/**
	 * 屏蔽的词语（管理员）
	 */
	public static function wordList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		$page = intval( $_GET['page'] );
		$manager = wordFilter::objects()->pageFilter('', 'id DESC');
		$page = new pagination($manager, 10, $page);  //分页
		$source = $_POST['source'];
		$replace = $_POST['replace'];
		if ( empty($_POST['source']) ) {
			template('wordList', array('page'=>$page), 'default/admin/system');
		}
		//写入数据库
		$word = new wordFilter();
		$word->source = $source;
		$word->replace = $replace;
		if ( $word->save() ){
			base::setAdminLog('屏蔽关键字');
			core::redirect("操作成功，正在跳转", URL . "index.php/admin/system/wordList");
		} else {
			core::alert('操作失败');
		}
	}
	
	/**
	 * 移除屏蔽（管理员）
	 */
	public static function wordDelete() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		base::checkRefresh();  //防刷新
		$id = intval( $_GET['id'] );
		if (empty($id)) {
			core::alert('非法操作');
			exit();
		}
		$word = new wordFilter();
		$word->id = $id;
		if ( $word->delete() ){
			core::redirect("操作成功，正在跳转", URL . "index.php/admin/system/wordList");
		} else {
			core::alert('操作失败');
		}
	}
	
	/**
	 * 审核设置
	 */
	public static function verifyEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);	
		if ( !count($_POST) ) {
			try {
				$verify = verify::objects()->all();
			} catch (Exception $e) {
				$verify = '';
			}
			template('verifyEdit', array('verify'=>$verify), 'default/admin/system');
		}
		
		$id = $_POST['id'];
		$value = $_POST['value'];		
		foreach ($id as $i=>$v) {
			$new = ($value[$i] == 1) ? 1 : '0';  //0或1，'0'需要加引号
			//写入数据库
			$verify = new verify();
			$verify->id = $v;
			$verify->value = $new;	
			$verify->save();
		}
		base::setAdminLog('更改审核设置');
		core::redirect("修改成功，正在跳转", URL . "index.php/admin/system/verifyEdit");
	}
	
	/**
	 * 通过审核（用于别的页面调用）
	 */
	public static function verifyPs() {
		AdminAuth::AuthAdmin();
		
		$id = intval( $_GET['id'] );
		$act = htmlspecialchars( $_GET['act'], ENT_QUOTES );
		
		$verify = new verify();
		$verify = (array)($verify);  //转为数组，以检测键名中是否含有$act
		if( !array_key_exists( $act, $verify ) ) {
			die('非法操作');  //避免非法的数据库操作
		}
		//将数据库中的verify值更新为1（即通过审核），$act为表名
		$model = new $act();
		$model->id = $id;
		$model->verify = 1;
		if ( $model->save() ) {
			core::alert('操作成功');
		} else {
			core::alert('操作失败');
		}
	}
	
	/**
	 * 网站信息设置
	 */
	public static function sysConfig() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		
		$title = base::getConfig('TITLE');
		$des = base::getConfig('DES');
		$word = base::getConfig('KEY_WORD');
		if ( !count($_POST) ) {
			template('sysConfig', array('title'=>$title, 'des'=>$des, 'word'=>$word), 'default/admin/system');
		}
		$title = htmlspecialchars( $_POST['title'], ENT_QUOTES );
		$des = htmlspecialchars( $_POST['des'], ENT_QUOTES );
		$word = htmlspecialchars( $_POST['word'], ENT_QUOTES );
		if (empty($title) || empty($des) || empty($word)) {
			core::alert('请填写完整信息');
		}
		base::setConfig('TITLE', $title);
		base::setConfig('DES', $des);
		base::setConfig('KEY_WORD', $word);
		
		base::setAdminLog('更改网站信息');
		core::redirect("操作完毕，正在跳转", URL . "index.php/admin/system/sysConfig");
	}
	
	/**
	 * 关闭网站
	 */
	public static function siteClose() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(8);
		
		$close = base::getConfig('CLOSE');
		$reason = base::getConfig('CLOSE_REASON');
		if ( !count($_POST) ) {
			template('siteClose', array('close'=>$close, 'reason'=>$reason), 'default/admin/system');
		}
		$close = intval( $_POST['close'] );
		$reason = htmlspecialchars( $_POST['reason'], ENT_QUOTES );
		if ( empty($reason) || $close > 1 || $close < 0 ) {
			core::alert('请填写完整信息');
		}
		base::setConfig('CLOSE', $close);
		base::setConfig('CLOSE_REASON', $reason);
		
		base::setAdminLog('更改网站状态');
		core::redirect("操作完毕，正在跳转", URL . "index.php/admin/system/siteClose");
	}
	
	/*
	 * 开启关闭伪静态,静态
	*/
	public static function rewrite(){

		if(!count($_POST)){
			$rewrite = config::objects()->get("keyword='REWRITE'");
			$state = config::objects()->get("keyword='ISSTATIC'");
			template('rewrite',array('rewrite'=>$rewrite,'state'=>$state),'default/admin/system');
		}
		require_once PRO_ROOT.'include/other.class.php';
		$rewrite = $_POST['rewrite'];
		$value = $_POST['isstatic'];
		
		$flag = other::SetConfig('REWRITE',$rewrite);
		$sflag = other::SetConfig('ISSTATIC',$value);
		if($flag){
			core::alert( "设置伪静态成功！");
		}
		if($sflag){
			core::alert( "设置静态成功！");
		}
	}
	
}