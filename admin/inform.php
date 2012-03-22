<?php
/**
 * 价格举报 
 * @author johz
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
class informViews {	

	/**
	 * 商品价格举报列表 前台
	 */
	public static function informList($gid='') {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(3);
		
		$gid = ($gid) ? $gid : $_GET['gid'];
		if($gid) $where = " gid='$gid' "; 


		$page = other::getInformList($where);
		template("informList", array('page'=>$page), 'default/admin/inform');
	}


	/**
	 * 用户提交 举报
	 */
	public static function informAdd() {
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新
		$url = htmlspecialchars( $_POST['url'], ENT_QUOTES );
		$content = htmlspecialchars( $_POST['content'], ENT_QUOTES );
		$gid = intval( $_GET['gid'] );
		$uid = auth::getUserId();
		$id = intval( $_GET['id'] );

		if(empty($uid) || (empty($gid) && empty($id))) core::alert('错误，请返回重试！');

		if(!empty($id)){ 
			$sql = "select uid from inform where id='$id'";             // 判断是否本人编辑
			$result = question::objects()->QuerySql($sql);
			if($result[0]['uid']!=$uid){
				core::alert('您无权编辑该记录！');	
				exit();
			 }	 	 
		}	

		if (empty($url) || empty($content)) {
			$informInfo = other::getInform($id);	
			template("informAdd", array('url'=>$informInfo->url, 'content'=>$informInfo->content), 'default/front/inform');
		}

		$time = time();
		//数据库
		$inform = new inform();
		$inform->id = $id;
		$inform->uid = $uid;
		$inform->gid = $gid;
		$inform->url = $url;
		$inform->questiontime = $time;
		$inform->state = 0;
		$inform->content = $content;
		$rs = $inform->save();
		
		if ($rs){
			core::alert('提交成功！');
		}else {
			core::alert('提交失败！');
		}
		
	}


	/**
	 * 用户删除价格举报
	 */
	public static function informDel() {
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新

		$id = intval( $_GET['id'] );
		$uid = auth::getUserId();

		//数据库
		
        $sql = "select uid from inform where id='$id'";             // 判断是否本人删除
		$result = question::objects()->QuerySql($sql);
		if(empty($result)){
			core::alert('记录不存在！');
			exit();
		}elseif($result[0]['uid']!=$uid){
			core::alert('您无权删除该记录！');
			exit();
		}


		//数据库
		$inform = new inform();
        $inform->id = $id;
		$rs = $inform->delete();
		
		if ($rs){
			core::alert('删除成功！');
		}else {
			core::alert('删除失败！');
		}
		
	}


	/*
	* just for test 
	*/
	public function test() {
         //
	}

}