<?php

/*
 * ��Ʒǰ̨���б�ҳ����Ʒ��ϸҳ
 *  
*/

if (!defined("PRO_ROOT")) {
	exit();
}

class goodsfrontViews{
	
	public static function goodsdetail(){
		require_once PRO_ROOT.'include/goods.class.php';
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		//$gid = 20;
		$detail = Ware::GetFrontData($gid);
		template('goodsdetail',$detail,'default/front');
	}
	
	/*
	 * 获取浏览过的商品
	*/
	public static function goodsviewed(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		//echo $gid;
		//获取浏览过的商品
		$views = array();
		$views = explode(',',$_COOKIE['viewgoods']);
		$viewed = GoodsFront::GetViewed($_COOKIE['viewgoods'],'id');
		if(!empty($views)){
			if($gid){	
				array_unshift($views,$gid);
			}
			$views = array_unique($views);
			if(count($views)>VIEWSCOUNT){
				array_pop($views);
			}
			
			$viewgids = implode(',',$views);
			setcookie('viewgoods',$viewgids,time()+date('Z')+3600*24*30);
		}else{
			setcookie('viewgoods',$gid,time()+date('Z')+3600*24*30);
		}
		echo $viewed;
	}

	/*
	 * 清楚浏览记录
	*/
	public static function clearviewed(){
		if(setcookie('viewgoods','')){
			echo "<span style='font-weight:bold;margin:auto;'>暂无浏览记录</span>";
		}
	}
	
	/*
	 * 获取前台页面显示的5条评论
	*/
	public static function goodscomments(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$where = "goodsid=".$gid;
		$comments = Comments::GoodsComments($where,$gid);
		echo $comments;
	}
	
	/*
	 * 获取前台显示的5条好评
	*/
	public static function goodcomments(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$where = "goodsid=".$gid." AND score=5";
		$comments = Comments::GoodsComments($where,$gid);
		echo $comments;
	}
	
	/*
	 * 获取5条中评
	*/
	public static function medcomments(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$where = "goodsid=".$gid." AND score>=3 AND score<=4";
		$comments = Comments::GoodsComments($where,$gid);
		echo $comments;
	}
	
	/*
	 * 获取5条差评
	*/
	public static function badcomments(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$where = "goodsid=".$gid." AND score<=2";
		$comments = Comments::GoodsComments($where,$gid);
		echo $comments;
	}
	
	/*
	 * 获取商品评论的数量
	*/
	public static function goodscommnetcount(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$count = Comments::GetCommentCount("goodsid=".$gid);
		echo $count;
	}
	
	/*
	 * 获取商品好评的数量
	*/
	public static function goodcommentcount(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$count = Comments::GetCommentCount("goodsid=".$gid." AND score=5");
		echo $count;
	}
	
	/*
	 * 获取商品中评的数量
	*/
	public static function medcommentcount(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$count = Comments::GetCommentCount("goodsid=".$gid." AND score>=3 AND score<=4");
		echo $count;
	}
	
	/*
	 * 获取商品差评数量
	*/
	public static function badcommentcount(){
		require_once PRO_ROOT.'include/commentFun.class.php';
		$gid = $_GET['gid'];
		$count = Comments::GetCommentCount("goodsid=".$gid." AND score<=2");
		echo $count;
	}
	
	/*
	 * 获取全部咨询
	*/
	public static function getzqall(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		$zqlist = GoodsFront::GetZQList("gid=".$gid,$gid);
		echo $zqlist;
	}
	
	
	/*
	 * 获取库存配货咨询
	*/
	public static function getzqgoods(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		$zqlist = GoodsFront::GetZQList("gid=".$gid." AND type=1",$gid);
		echo $zqlist;
	}
	
	/*
	 * 获取库存配货咨询
	*/
	public static function getzqsend(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		$zqlist = GoodsFront::GetZQList("gid=".$gid." AND type=2",$gid);
		echo $zqlist;
	}
	
	/*
	 * 获取支付咨询
	*/
	public static function getzqpay(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		$zqlist = GoodsFront::GetZQList("gid=".$gid." AND type=3",$gid);
		echo $zqlist;
	}
	
	/*
	 * 获取发票保修咨询
	*/
	public static function getzqinvoice(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$gid = $_GET['gid'];
		$zqlist = GoodsFront::GetZQList("gid=".$gid." AND type=4",$gid);
		echo $zqlist;
	}

	/*
	 * 获取发票保修咨询
	*/
	public static function gethotgoods(){
		$cid = intval($_GET['cid']);
		require_once PRO_ROOT . 'models.php';
		require_once PRO_ROOT . 'include/other.class.php';
		require_once PRO_ROOT . 'include/goodsfront.class.php';
		try{
			$hot_goods = goods::objects()->QuerySql("select goods.id,goodsname,imgcurrent,shopprice,marketprice from goods INNER JOIN goodscategory gc ON goods.id=gc.goodsid WHERE ishot=1 and isonsale>0 AND gc.categoryid=".$cid,3,0,10);
		}catch(DZGException $e){
			$hot_goods = array();
		}
		$str = "<ul class=\"index_img\">";
		for($i=0;$i<count($hot_goods);$i++){
			$str .= "<li><div class=\"tu\"><a href=\" ".GoodsFront::GetUrl('goods',array('gid'=>$hot_goods[$i]['id']))."\" title=\"".$hot_goods[$i]['goodsname']."\" ><img src=\"";
			if($hot_goods[$i]['imgcurrent']==''){$str .= MEDIA_URL.'img/no_picture.gif';}
			else{ $str .= GoodsFront::GetChangeImg('99',$hot_goods[$i]['imgcurrent']); }
            $str .= "\"  height=\"99\" width=\"99\" /></a>";
			if($i<5){$str .= "<div class=\"gj2\">".($i+1)."</div>";}
			$str .= "</div><h2 style=\"text-align:center\"><a href=\" ".GoodsFront::GetUrl('goods',array('gid'=>$hot_goods[$i]['id']))." \" title=\"".$hot_goods[$i]['goodsname']."\">".other::cn_substr_utf8($hot_goods[$i]['goodsname'],15,0)."</a></h2><p class=\"fn_hs s\">市场价：￥".$hot_goods[$i]['marketprice']."</p><p class=\"fn_red\">现价：<span class=\"fn_14px b\">￥".$hot_goods[$i]['shopprice']."</span></p></li>";
		}
		$str .= "</ul>";
		echo $str;
	}

	/*
	 * 商品列表
	*/
	public static function goodslist(){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		require_once DZG_ROOT.'core/pagination/pagination.php';
		
		$cid = isset($_GET['cid'])?$_GET['cid']:0;
		$wid = isset($_GET['wid'])?$_GET['wid']:0;
		$bid = isset($_GET['bid'])?$_GET['bid']:0;
		
		$page = isset($_GET['page'])?$_GET['page']:1;
		$sort= isset($_GET['sort'])?$_GET['sort']:1;
		$sortflag = isset($_GET['sortflag'])?$_GET['sortflag']:1;
		$attr = isset($_GET['attr'])?$_GET['attr']:'0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0';
		
		if(!$bid||!$wid){
			$navigation = GoodsFront::GetNavigation($cid);
			$categorys = GoodsFront::GetCateNavi($cid,$attr);
		}else{
			$navigation = GoodsFront::GetNavigationB($bid,$wid);
			$categorys = '';
		}
		//echo $navigation;
		
		//echo $sortflag.'sortflag';
		//放在GetGoodsListTab下面
		if($sortflag==1){
			$sflag = 'DESC'; 
		}else{
			$sflag = 'ASC';
		}
		$goodslisttab = '';
		$goodslist = '';
		if($attr=='0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0'){
			$goodslisttab = GoodsFront::GetGoodsListTab($cid,$page,$sortflag,$attr);
			$goodslist = GoodsFront::GetGoodsList($cid,$sort,$page,$sflag);
		}else if($bid||$wid){
			$goodslisttab=GoodsFront::GetGoodsListTab($cid,$page,$sortflag,$attr,$bid,$wid);
			$goodslist = GoodsFront::GetGoodsListB($bid,$wid,$sort,$page,$sflag);
		}else{
			$goodslisttab = GoodsFront::GetGoodsListTab($cid,$page,$sortflag,$attr);
			$goodslist = GoodsFront::GetGoodsListA($cid,$sort,$page,$attr,$sflag);
		}
		
		$viewed = GoodsFront::GetViewed();
		//商品数量
		$goodscount = GoodsFront::GetGoodsCount();
		//echo $goodslist;
		$goods = array(
			'navigation'=>$navigation,
			'categorys'=>$categorys,
			'goodslisttab'=>$goodslisttab,
			'goodslist'=>$goodslist,
			'goodscount'=>$goodscount,
			'sort'=>$sort,
		);
		template('goodslist',$goods,'default/front');
	}
}
?>