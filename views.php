<?php
if (!defined("PRO_ROOT")) {
	echo "die";
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
class viewsViews {
	public static function index() {

 		require_once PRO_ROOT . 'include/goodsfront.class.php';
		auth::isUserLogin();
		$uid = auth::getUserId();
		$uname = auth::getUserName();
		
		try{              //新品推荐
			$new_goods = goods::objects()->QuerySql("select id,goodsname,shopprice,imgcurrent,marketprice from goods where isnew = 1 and isonsale>0 order by id desc",3,0,8);
		}catch(DZGException $e){
			$new_goods = array();
		}

		try{    //热销精品
			$hot_goods = goods::objects()->QuerySql("select goods.id,goodsname,shopprice,imgcurrent,marketprice from goods INNER JOIN goodscategory gc ON goods.id=gc.goodsid WHERE ishot=1 and isonsale>0 AND gc.categoryid=1",3,0,8);
		}catch(DZGException $e){
			$hot_goods = array();
		}

		try{     //商场公告
			$notice = goods::objects()->QuerySql("select id,title from article WHERE sort=9 order by id desc",3,0,3);
		}catch(DZGException $e){
			$notice = array();
		}

		try{     //今日特价  and FROM_UNIXTIME(edittime,'%Y-%m-%d')='".date('Y-m-d')."'
			$promote = goods::objects()->QuerySql("select id,goodsname,imgcurrent,shopprice,marketprice from goods where ispromotion=1  and isonsale>0 order by edittime, id desc",3,0,2);
		}catch(DZGException $e){
			$promote = array();
		}

		try{     //轮换图片
			$pics = goods::objects()->QuerySql("SELECT max(a.filename), g.goodsname, g.des,g.id FROM goods g LEFT JOIN goodsattachment ga ON g.id = ga.goodsid LEFT JOIN attachment a ON ga.aid = a.id WHERE a.filename != '' group by  g.goodsname, g.des,g.id ORDER BY g.id DESC ",3,0,6);
		}catch(DZGException $e){
			$pics = array();
		}

		try{     //品牌
			$brand = goods::objects()->QuerySql("select id,bname,bpicpath,des,isindex from tag where isindex=1 order by id desc",3,0,5);
		}catch(DZGException $e){
			$brand = array();
		}

		try{
			$works = works::objects()->filter("isindex=1"," id ",0,5);
		}catch(DZGException $e){
			$works = array();
		}
		template("index",
			
			array(
			'uid'=>$uid,
			'uname'=>$uname,
			'new_goods'=>$new_goods,
			'hot_goods'=>$hot_goods,
			'notice'=>$notice,
			'brand'=>$brand,
			'promote'=>$promote,
			'works'=>$works,
			'pics'=>$pics),
			
			'default/front/');
	}
	
	/**
	 * 检查order_sn是否存在（Ajax）
	 * 输出订单ID，没有则输出'0'，重复提交则输出false
	 */
	public static function checkOrderSn() {
		base::checkRefresh();
		$sn = htmlspecialchars($_REQUEST['sn'], ENT_QUOTES);
		try{
			$order = orders::objects()->get("order_sn = '$sn'");
			$order = $order->id;
		}catch (Exception $e) {
			$order = '0';
		}
		die($order);
	}
	
	/**
	 * 地区的级联选择（Ajax）
	 */
	public static function regionSelect() {
		base::checkRefresh();
		$id = intval( $_REQUEST['id'] );
		$region = base::getRegion($id);
		//输出option选项HTML
		echo '<option value="">请选择...</option>';
		foreach ($region as $i=>$v) {
			echo '<option value="' . $v->id . '">' . $v->region_name . '</option>';
		}
	}
	
	/**
	 * 文章 列表页
	 */
	public static function articleList() {
		$array = other::getArticleList();
		template("articleList", $array , 'article');
	}
	
	/**
	 * 评论 处理提交的回复（Ajax）
	 */
	public static function commentReply() {
		base::checkRefresh();  //防刷新
		$rs = other::commentReply();
		if ( $rs ) {
			die('1');
		} else {
			die();
		}
	}
}