<?php
/**
 * 我的收藏夹
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';

class collectViews{
	/**
	 * 我的收藏夹
	 */
	public static function index() {
        auth::authUser();   // 用户验证
	//	base::checkRefresh();  //防刷新
        $uid = auth::getUserId();
		$uname = auth::getUserName();
		if (empty($orderid) || empty($bankcard)) {
			$page = intval($_GET['page']);
			$manager = collect::objects()->pageFilter("uid = $uid", 'id DESC');  //按id倒序排列
			$collect = new pagination($manager, PAGE_SIZE, $page);  //分页
			$count=$refund->dataCount;
            $navigation = NAV_MY . '> <a>收 藏 夹</a>';
			require_once PRO_ROOT.'include/goodsfront.class.php';
			template("collect", array('collect'=>$collect,'page'=>$page,'count'=>$count,'uname'=>$uname,'navigation'=>$navigation), 'default/front/collect');
			exit();
		}
		
	}

	/**
	 * 加入收藏夹
	 */
	public static function Add($ajax=0,$gid='',$uid='') {
        auth::ParseCookie();   // 用户验证
		base::checkRefresh();  //防刷新
        $uid = ($id) ? $uid : auth::getUserId();
		$gid = ($gid) ? $gid : $_GET['gid'];
		$ajax = ($ajax) ? $ajax : $_GET['ajax'];

		if($uid == ''){
			if($ajax=='1'){
			       die('login');
			} else {
				core::alert('请先登录！');
			    exit();
			}

		}

        $sql = "select id from collect where uid='$uid' and gid='$gid' ";             // 判断是否已收藏
		$result = collect::objects()->QuerySql($sql);
		//print_r($result);exit;
		if(!empty($result)){
			if($ajax=='1'){
			       die('exist');
			} else {
				core::alert('您已收藏该商品！');
			    exit();
			}

		}
		$collect = new collect();
		$collect->uid = $uid;
		$collect->gid = $gid;
		$collect->collecttime = time();
		$rs = $collect->save();
		
		if ($rs){
			if($ajax=='1'){
			       die('ok');
			} else {
				core::alert('收藏成功！');
			    exit();
			}
		}else {
			if($ajax=='1'){
			       die('false');
			} else {
				core::alert('收藏失败！');
			    exit();
			}
		}
		
	}

	/**
	 * 删除收藏
	 */
    public static function Del(){
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新
		$uid = auth::getUserId();
		$id = $_GET['id'];
        $sql = "select uid from collect where id='$id'";             // 判断是否本人删除
		$result = collect::objects()->QuerySql($sql);
		if(empty($result)){
			core::alert('记录不存在！');
			exit();
		}elseif($result[0]['uid']!=$uid){
			core::alert('您无权删除该信息！');
			exit();
		}
		$collect = new collect();
        $collect->id = $id;
		$rs = $collect->delete();
		if ($rs){
			core::alert('删除成功！');
		}else {
			core::alert('删除失败！');
		}
	}

	public static function intoCart(){
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新
		$uid = auth::getUserId();
		$gid = $_GET['gid'];

		require_once PRO_ROOT . 'include/cartFun.class.php';
		$che = cartFun::checkCartGoods($gid,$uid,'');    //检查购物车中是否存在此商品
		if($che == 'noexist'){
			if(cartFun::cartAdd($gid,$uid,'')){
				core::alert('加入购物车成功！');
			} else {
				core::alert('操作失败');
			}
		}elseif($che =='exist'){
			core::alert('购物车中已经存在此商品！');
		}
	}

}
?>