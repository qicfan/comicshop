<?php
/**
 * 购买咨询
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
require_once PRO_ROOT . 'include/questions.class.php';
class questionViews {	
	/**
	 * 用户咨询列表
	 */
	public static function userQuestion() {
		auth::authUser();
        $page = intval( $_GET['page'] );
		$type = intval( $_GET['type'] );

		if ( empty($type) ) {
			$where = "1 = 1";  //提问
		} else {
			$where = " type = $type";  //投诉
		} 
        $uid = auth::getUserId();
        $where .= " and uid=$uid ";   
        require_once PRO_ROOT.'include/goodsfront.class.php';
		$manager = question::objects()->pageFilter($where, 'id DESC');  //按id倒序排列
		$page = new pagination($manager, PAGE_SIZE, $page);  //分页
		$count=$page->dataCount;
		$navigation = NAV_MY . '> <a>我的咨询</a>';

		template("userQuestion", array('page'=>$page, 'type'=>$type, 'count'=>$count, 'uname'=>auth::getUserName(),'navigation'=>$navigation), 'default/front/question');
	}

	/**
	 * 商品咨询列表 前台
	 */
	public static function questionList($gid='') {
        auth::ParseCookie();   // 解析cookie
		$gid = ($gid) ? $gid : $_GET['gid'];
		$type = intval( $_GET['tab'] );

		if ( empty($type) ) {
			$where = " 1 = 1 ";  //所有
		} else {
			$where = " type = $type ";  //1留言 2询问 3投诉 4求购
		} 
		$verify = base::checkVerify('question');                 //是否需求审核
		if($verify == '1') {
			$where .= " and verify='1' ";
		}

		$where .= " and gid=$gid";

		require_once PRO_ROOT.'include/goods.class.php';
        require_once PRO_ROOT.'include/goodsfront.class.php';

        $good = Ware::GetOne($gid);
		$page = other::getQuizList($where);
		$array = array('page'=>$page, 'type'=>$type, 'good'=>$good, 'gid'=>$gid, 'navigation'=>$navigation, 'uname'=>auth::getUserName());

		template("questionList", $array , 'default/front/question');
	}	

	/**
	 * 用户提交咨询
	 */
	public static function questionAdd() {
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新
		$title = htmlspecialchars( $_POST['title'], ENT_QUOTES );
		$content = htmlspecialchars( $_POST['content'], ENT_QUOTES );
		$gid = intval( $_GET['gid'] );
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		$type = $_POST['type'];

		$id = intval( $_GET['id'] );
		if(empty($uid) || (empty($gid) && empty($id))) core::alert('错误，请返回重试！');

		if(!empty($id)){ 
			$sql = "select uid from question where id='$id'";             // 判断是否本人编辑
			$result = question::objects()->QuerySql($sql);
			if($result[0]['uid']!=$uid){
				core::alert('您无权编辑该记录！');	
				exit();
			 }	 	 
		}

		if (empty($content)) {
			$quizInfo = other::getQuiz($id);	
			template("questionAdd", array('title'=>$quizInfo->title, 'content'=>$quizInfo->content, 'type'=>$quizInfo->type), 'default/front/question');
		}

		$time = time();
		//数据库
		$quiz = new question();
		$quiz->id = $id;
		$quiz->uid = $uid;
		$quiz->gid = $gid;
		$quiz->type = $type;
		$quiz->uname = $uname;
		$quiz->title = $title;
		$quiz->questiontime = $time;
		$quiz->state = 0;
		$quiz->content = $content;
		$rs = $quiz->save();
		
		if ($rs){
			core::alert('提交成功！');
		}else {
			core::alert('提交失败！');
		}

	}


	/**
	 * 用户删除咨询
	 */
	public static function questionDel() {
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新

		$id = intval( $_GET['id'] );
		$uid = auth::getUserId();

		//数据库
		
        $sql = "select uid from question where id='$id'";             // 判断是否本人删除
		$result = question::objects()->QuerySql($sql);
		if(empty($result)){
			core::alert('记录不存在！');
			exit();
		}elseif($result[0]['uid']!=$uid){
			core::alert('您无权删除该记录！');
			exit();
		}

		$quiz = new question();                                       //开始删除
        $quiz->id = $id;
		$rs = $quiz->delete();
		
		if ($rs){
			core::alert('删除成功！');
		}else {
			core::alert('删除失败！');
		}
		
	}

//	public static function intoCart(){
//        //auth::ParseCookie();   // 解析cookie
//		base::checkRefresh();  //防刷新
//		//$uid = auth::getUserId();
//		$gid = $_GET['gid'];
//
//		require_once PRO_ROOT . 'include/cartFun.class.php';
//		$che = cartFun::checkCartGoods($gid,$uid,'');    //检查购物车中是否存在此商品
//		if($che == 'noexist'){
//			if(cartFun::cartAdd($gid,$uid,'')){
//				core::alert('加入购物车成功！');
//			} else {
//				core::alert('操作失败');
//			}
//		}elseif($che =='exist'){
//			core::alert('购物车中已经存在此商品！');
//		}
//	}

    public static function comment(){
        auth::ParseCookie();   // 用户验证
		base::checkRefresh();  //防刷新
        $uid = auth::getUserId();
		$qid = $_GET['qid'];
		$val = $_GET['val'];
		if($uid == ''){
			die('login');
		}
        $sql = "select id from questioncomment where uid='$uid' and qid='$qid'";             // 判断是否已投票
		$result = question::objects()->QuerySql($sql);
		if(!empty($result)){
			die('0');
		}
        $qc = new questioncomment();
		$qc->id = $id;
		$qc->uid = $uid;
		$qc->qid = $qid;
		$qc->val = $val;
		$qc->time = time();
		$rs = $qc->save();
		
		if ($rs){
			echo '1';
		}else {
			echo '0';
		}
	}
	public static function getReply($qid){
		$qid = ($qid) ? $qid :$_GET['qid'];
		$sql = "select reply from question where id='$qid'";             // 判断是否本人删除
		$result = question::objects()->QuerySql($sql);
		echo $result['0']['reply'];
	}

	/*
	 * 静态重写的url获取
	 * @param string $type 执行的页面，比如是商品页面，文章页面
	 * @param array $params 传过来页面的参数,比如分类id，商品id
	 * @param array $arr 页面中的其他参数
	 * @param string $keyword 查询的关键字
	*/
	public static function GetUrl($type,$params=array(),$arr=array(),$keyword=''){
		$idarr = array(
			'gid'=>0,
			'cid'=>0,
			'aid'=>0,
		);
		
		$attr = array(
			'page'=>1,
			'sort'=>1,
			'sortflag'=>1,	
			'attr'=>'0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0'
		);
		
		$url = '';
		extract(array_merge($idarr,$params));
		extract(array_merge($attr,$arr));
		$i=0;
		//获取伪静态的路径
		define('REWRITE',1);
		if(REWRITE){
			$url = "http://".$_SERVER['HTTP_HOST']."/goodslist";
			$url .= "_".$cid;
			$url .= "_".$page;
			$url .= "_".$sort;
			$url .= "_".$sortflag;
			$url .= ".html";
		}else{
			$url = URL."index.php/front/goodsfront/goodslist?cid=".$cid."&page=".$page."&sort=".$sort;
			if($sortflag=='DESC'){
				$url .= "&sortflag=1";
			}else{
				$url .= "&sortflag=2";
			}
		}
		
		
		return $url;
	}

	/*
	* just for test 
	*/
	public function test() {

          print_r(Questions::Get('18'));

//		echo  $uid = auth::getUserId();
//		
//        require_once PRO_ROOT . 'include/userFun.class.php';
//		$uinfo = userFun::getUserInfoById('15388');
//		print_r($uinfo);
//        echo "<br/>";
//		echo $uinfo->email;

	}

}