<?php
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/proFun.class.php';
class promotionViews{
	/**
	 * 促销列表页
	 */
	public static function proList(){
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(112)){
			$pagefile = activity::objects()->pageFilter('');
			$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
			$proinfo = $page->objectList();
			$url = base::getUrl();
			$html = $page->getHtml($url);
			template("prolist", array('proinfo'=>$proinfo,'page'=>$html), "default/admin/promotion");
		}
	}

	/**
	 * 促销添加
	 */
	public static function proAddPage(){
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(111)){
			template("proadd",array(),"default/admin/promotion");
		}
	}
	
	public static function proAdd(){
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(111)){
			$proname = $_GET['proname'];
			$start_time = strtotime($_GET['start_time']);
			$stop_time = strtotime($_GET['stop_time']);
			$active_type = $_GET['active_type'];
			$mode = $_GET['mode'];
			$result = activity::objects()->filter("act_title='$proname'");    //根据活动名称判断活动是否存在
			if($result){
				base::autoSkip("此操作无效，可能存在此活动！","正在转入","proAddPage");
				die;
			}else{
				switch($mode){
					case 'rebate':
						$typ = 1;
						break;
					case 'freight':
						$typ = 5;
						break;
					case 'gift':
						$typ =2;
						break;
					case 'integral':
						$typ =3;
						break;
					case 'cheap':
						$typ =4;
						break;
				}
				$ty = proFun::proGlobalByType($typ);
				if($ty){
					base::autoSkip("此操作无效，可能存在此类活动！","正在转入","proAddPage");
					die;
				}else{
					$activity = new activity();
					if($mode=='rebate'){
						$amount = $_GET['amount'];
						$rebate = $_GET['rebate'];
						$activity -> activity_type =1;
						$activity -> act_agio = $rebate;
						$activity -> buy_amount = $amount;
					}
					if($mode=='freight'){
						$freight = $_GET['freight'];
						$activity -> activity_type =5;
						$activity -> money = $freight;
					}
					if($mode=='gift'){
						$buyamount = $_GET['buyamount'];
						$goodsinfo = $_GET['goodsinfo'];
						$giveamount = $_GET['giveamount'];
						$activity -> activity_type =2;
						$activity -> buy_amount = $buyamount;
						$activity -> give_goods = $goodsinfo;
						$activity -> give_amount = $giveamount;
					}
					if($mode=='integral'){
						$integralmoney = $_GET['integralmoney'];
						$integral = $_GET['integral'];
						$activity -> activity_type =3;
						$activity -> money = $integralmoney;
						$activity -> integral = $integral;
					}
					if($mode=='cheap'){
						$cheapmoney = $_GET['cheapmoney'];
						$cheapvalue = $_GET['cheapvalue'];
						$activity -> activity_type =4;
						$activity -> money = $cheapmoney;
						$activity -> cheap = $cheapvalue;
					}
				
					$activity -> act_title = $proname;
					$activity -> start_time = $start_time;
					$activity -> stop_time = $stop_time;
					$activity -> act_type = $active_type;
					$rel = $activity -> save();
					if($rel){
						base::autoSkip("恭喜您，操作成功！","正在转入","proList");
					}
				}	
			}
		}
	}

	/**
	 * 查看促销详情
	 */
	public static function proSel(){
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(112)){
			$proid = $_GET['proid'];
			$rel = activity::objects()->get("id='$proid'");
			if($rel->give_goods!=0){
				$gift = goods::objects()->get("id=".$rel->give_goods);
			}else{
				$gift='';
			}
			if($rel){
				template("proinfo",array('proinfo'=>$rel,'gift'=>$gift),"default/admin/promotion");
			}
		}
	}
	
	/**
	 * 促销修改
	 */
	public static function proUpdate(){
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(113)){
			$proid = $_GET['proid'];
			$proname = $_GET['proname'];
			$start_time = strtotime($_GET['start_time']);
			$stop_time = strtotime($_GET['stop_time']);
			$active_type = $_GET['active_type'];
			$mode = $_GET['mode'];
			$activity = new activity();
			if($mode=='rebate'){
				$amount = $_GET['amount'];
				$rebate = $_GET['rebate'];
				$activity -> activity_type =1;
				$activity -> act_agio = $rebate;
				$activity -> buy_amount = $amount;
			}
			if($mode=='freight'){
				$freight = $_GET['freight'];
				$activity -> activity_type =5;
				$activity -> money = $freight;
			}
			if($mode=='gift'){
				$buyamount = $_GET['buyamount'];
				$goodsinfo = $_GET['goodsinfo'];
				$giveamount = $_GET['giveamount'];
				$activity -> activity_type =2;
				$activity -> buy_amount = $buyamount;
				$activity -> give_goods = $goodsinfo;
				$activity -> give_amount = $giveamount;
			}
			if($mode=='integral'){
				$integralmoney = $_GET['integralmoney'];
				$integral = $_GET['integral'];
				$activity -> activity_type =3;
				$activity -> money = $integralmoney;
				$activity -> integral = $integral;
			}
			if($mode=='cheap'){
				$cheapmoney = $_GET['cheapmoney'];
				$cheapvalue = $_GET['cheapvalue'];
				$activity -> activity_type =4;
				$activity -> money = $cheapmoney;
				$activity -> cheap = $cheapvalue;
			}
			$activity -> id = $proid;
			$activity -> act_title = $proname;
			$activity -> start_time = $start_time;
			$activity -> stop_time = $stop_time;
			$activity -> act_type = $active_type;
			$rel = $activity -> save();
			if($rel){
				base::autoSkip("恭喜您，操作成功！","正在转入","proSel?proid=".$proid);
			}
		}
	}

	/**
	 * 促销删除
	 */
	public static function proDel(){
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(114)){
			$proid = $_GET['proid'];
			$activity = new activity();
			$activity->id = $proid;
			$rel = $activity->delete();
			if($rel){
				$del = proFun::proGoodsDel($proid);
				if($del){
					base::autoSkip("恭喜您，操作成功！","正在转入","proList");
				}
			}
		}
	}

	/**
	 * 促销商品添加
	 */
	public static function proGoodsAddPage(){
		$proid = $_GET['proid'];
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(116)){
			if($proid==''){
				base::autoSkip("Sorry 操作失败，请通过正确的操作顺序操作！","正在转入",URL);
			}else{
				template("progoodsadd",array('proid'=>$proid),"default/admin/promotion");
			}
		}
	}

	/**
	 * 根据关键字查活动
	 */
	public static function getActivityByField(){
		base::checkRefresh();  //防刷新
		$field = $_POST['field'];
		$actinfo = activity::objects()->filter(" act_title like '%$field%'");

		print_r(json_encode($actinfo));
		die;
	}

	/**
	 * 添加促销商品
	 */
	public static function proGoodsAdd(){
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(116)){
			$proid = $_GET['proid'];
			$actgoods = $_GET['actgoods'];
			$actg = explode(',',$actgoods);
			for($i=0;$i<count($actg);$i++){
				$bol = proFun::checkActivityGoods($actg[$i],$proid);
				if($bol){
					$gact = new goods_activity();
					$gact -> goods_id = $actg[$i];
					$gact -> act_id = $proid;
					$gact -> save();
				}
			}
			base::autoSkip("恭喜您，操作成功！","正在转入","proList");
		}
	}

	/**
	 * 促销商品列表
	 */
	public static function proGoodsList(){
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(115)){
			$sql="SELECT ga.id AS gaid,ga.act_id,ga.goods_id,a.act_title,a.start_time,a.stop_time,g.goodsname,g.goods_sn FROM goods_activity ga JOIN activity a ON ga.act_id=a.id JOIN goods g ON ga.goods_id=g.id";
			$pagefile = orders::objects()->pageFilter('','',2,$sql);
			$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
			$proinfo = $page->objectList();
			$url = base::getUrl();
			$html = $page->getHtml($url);
			template("progoodslist",array('proinfo'=>$proinfo,'page'=>$html),"default/admin/promotion");
		}
	}

	/**
	 * 促销商品的删除
	 */
	public static function proGoodsDel(){
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(118)){
			$gproid = $_GET['gproid'];
			$goods_activity = new goods_activity();
			$goods_activity->id = $gproid;
			$rel = $goods_activity->delete();
			if($rel){
				base::autoSkip("恭喜您，操作成功！","正在转入","progoodslist");
			}
		}
	}

	/**
	 * 检查商品活动是否可以添加（主要用于前台判断）
	 */
	public static function checkAddActGoods(){
		$gid = $_GET['gid'];
		$actid = $_GET['actid'];
		$rel = proFun::checkActivityGoods($gid,$actid);
		if($rel){
			echo 'ok';
		}else{
			echo 'no';
		}
		die;
	}
	
}

?>