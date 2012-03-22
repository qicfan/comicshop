<?php
/**
 * 评论系统
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
require_once PRO_ROOT . 'include/goods.class.php';



class commentViews {
	/**
	 * 用户发表评论
	 */
	public static function userComment() {
		$gid = intval( $_GET['gid'] );
		//$gid=120;
		$act = $_GET['act'];
		if ($act != 'submit' || empty($gid)) {
			template('userComment', array('gid'=>$gid), 'default/admin/comment');
		}
		$score = intval($_POST['score']);
		$title = base::wordFilter($_POST['title']);
		$bad = base::wordFilter($_POST['bad']);
		$good = base::wordFilter($_POST['good']);
		$summary = base::wordFilter($_POST['summary']);
		if (empty($title) || empty($summary)|| empty($good) || empty($bad) || $score > 5 || $score < 1 ) {
			core::alert('请认真填写评论');
			exit();
		}
		/* Todo：只有购买了商品才能进行评价,并且没有评价过,购买时间未超过半年 */
		//auth::authUser();
		//$uid = auth::getUserId();
		//$uname=auth::getUserName();//添加用户名，便于查询
		//commentViews::commentTest($uid,$gid);

		$time = time();
		//数据库
		$comment = new comment();
		$comment->goodsid = $gid;
		$comment->uid=$uid;//$comment->uid = 12;//$uid;//需要设置
		$comment->uname=$uname;
		$comment->score = $score;
		$comment->title = $title;
		$comment->ip = $_SERVER['REMOTE_ADDR'];
		$comment->good = $good;
		$comment->bad = $bad;
		$comment->verify=0;
		$comment->summary = $summary;
		$comment->createtime = $time;
		if ( $comment->save() ) {
			try{
				$where1="id='$gid'";
				$goodsmanager=goods::objects()->filter($where1,'');
				$count=$goodsmanager[0]->commentcount;
		    	ware::EditCommentCount($gid,$count);
			}catch(Exception $e){
				core::alert('评论失败');
			}
			core::alert('评论完毕');
		} else {
			core::alert('评论失败');
		}
	}
	
	/**
	 * 列出所有的用户评论（管理员，权限ID为5）
	 */
	public static function commentList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(5);
		$page = intval( $_GET['page'] );
		$manager = comment::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, 10, $page);  //分页
		foreach ($page->objectList() as $i=>$v) {
			$count[$i] = other::getCommentCount($v->id);
		}
		$verify = base::checkVerify('comment');
		template('commentList', array('page'=>$page, 'count'=>$count, 'verify'=>$verify), 'default/admin/comment');
	}
	
	/**
	 * 显示评论详情（管理员）
	 */
	public static function commentShow() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(5);
		$id = intval( $_GET['id'] );
		$array = other::getCommentDetail($id);
		template('commentShow', $array, 'default/admin/comment');
	}
	
	/**
	 * 删除评论或回复
	 */
	public static function commentDelete() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(5);
		$act = $_GET['act'];
		$id = intval($_GET['id']);
		//一个小的工厂
		if ($act == 'comment') {
			$comment = new comment;
		} else if ($act == 'reply') {
			$comment = new comment_reply;
		} else {
			die();
		}
		$comment->id = $id;
		if ( $comment->delete() ) {
			base::setAdminLog('删除用户评论或回复');  //记录管理员操作
			die('1');			
		} else {
			die();
		}
	}
	
	public static function commentTest($uid,$gid){
		//是否已经购买此产品，是否评论过
		$a=$uid;
		$b=$gid;
		$where="uid='$a' and goodsid='$b'";
		$manager = comment::objects()->filter($where, 'id DESC');
		
		$manager1=goodsorder::objects()->filter($where1,'');

		if(count($manager)){
		 	core::alert('您已经评论过了');
		}else{
			$manager1=goodsorder::objects()->filter($where,'');
			if(!count($manager1)){
				core::alert('您未购买此产品不能评论');
			}
		}

	}
}