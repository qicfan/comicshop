<?php
/**
 * 问答（留言）系统
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
class quizViews {	
	/**
	 * 用户留言列表（管理员，权限ID为3）
	 */
	public static function quizList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(3);		
		$type = intval( $_GET['type'] );
		$state = intval( $_GET['state'] );
		if ( empty($type) ) {
			$where = "1 = 1";  //全部
		} else {
			$where = " type ='$type' ";
		}
		if ($state=='1') {
			$where .= " and state='1' ";
		}elseif($state=='2'){
			$where .= " and state='0' ";
		}

		$page = other::getQuizList($where);
		$verify = base::checkVerify('question');
		template("quizList", array('page'=>$page, 'type'=>$type, 'state'=>$state, 'verify'=>$verify), 'default/admin/quiz');
	}
	
	/**
	 * 用户编写提问内容
	 */
	public static function quizEdit() {
		base::checkRefresh();  //防刷新
		$title = htmlspecialchars( $_POST['title'], ENT_QUOTES );
		$content = htmlspecialchars( $_POST['content'], ENT_QUOTES );
		if (empty($title) || empty($content)){
			template("quizEdit", array(), 'default/admin/quiz');
		}
		$type = $_POST['type'];
		$time = time();
		//数据库
		$quiz = new question();
		$quiz->uid = $uid;
		$quiz->title = $title;
		$quiz->questiontime = $time;
		$quiz->state = 0;
		$quiz->content = $content;
		$rs = $quiz->save();
		
		if ($rs){
			core::alert('留言成功！');
		}else {
			core::alert('留言失败！');
		}
		
	}
	
	/**
	 * 回复（管理员）
	 */
	public static function quizReply() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(3);
		base::checkRefresh();  //防刷新
		$id = intval( $_GET['id'] );
		$quizInfo = other::getQuiz($id);	
		$newReply = htmlspecialchars( $_POST['reply'], ENT_QUOTES );
		if ( empty($newReply) ) {
			template("quizReply", array('quiz'=>$quizInfo, 'content'=>$quizInfo->content, 'reply'=>$quizInfo->reply), 'default/admin/quiz');
		}
		//数据库
		$quiz = new question();
		$quiz->id = $id;
		$quiz->aid = AdminAuth::GetAdminId();
		$quiz->replytime = time();
		$quiz->state = 1;
		$quiz->reply = $newReply;
		$rs = $quiz->save();

		if ($rs) {
			base::setAdminLog('回复用户留言');
			core::alert('回复成功！');
		}else {
			core::alert('回复失败！');
		}
	}
}