<?php
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
/**
 * 订单管理后台
 * @author Zeroq
 *
 */
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/orderFun.class.php';
require_once PRO_ROOT . 'include/cartFun.class.php';
require_once PRO_ROOT . 'include/goods.class.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
class orderViews {
	/**
	 * 列表页搜索
	 * 2010/05/11 link
	 */
	public static function search(){
		AdminAuth::AuthAdmin();
		$admin = AdminAuth::GetAdminId();
		if($admin==''){
			base::autoSkip("Sorry 只有管理员才能进入","正在转入","login");
			die;
		}
		$order_sn = $_GET['order_sn'];
		$consignee = $_GET['consignee'];
		$orstate = $_GET['orstate'];
		$where='';
		if($order_sn!=''){
			$where.="order_sn = '$order_sn' AND ";
		}

		if($consignee!=''){
			$where.="consignee='$consignee' AND ";
		}

		if($orstate!=''){
			$where.="orderstate='$orstate' AND ";
		}

		if($where!=''){
			$condition = substr($where,0,-4);
		}else{
			$condition = '';
		}
		$pagefile = orders::objects()->pageFilter($condition,'createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
		die;
	}

	/**
	 * 订单列表
	 * 2010/05/11 link
	 */
	public static function orlist(){
		AdminAuth::AuthAdmin();
		$admin = AdminAuth::GetAdminId();
		if($admin==''){
			base::autoSkip("Sorry 只有管理员才能进入","正在转入","login");
			die;
		}
		if(AdminAuth::AdminCheck(71)){
			$pagefile = orders::objects()->pageFilter('','createtime desc ');
			$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
			$orinfo = $page->objectList();
			$url = base::getUrl();
			$html = $page->getHtml($url);

			template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
			die;
		}
		die;
	}

	/** 跳转到高级搜索页 */
	public static function orsearch(){
		AdminAuth::AuthAdmin();
		$admin = AdminAuth::GetAdminId();
		if($admin==''){
			base::autoSkip("Sorry 只有管理员才能进入","正在转入","login");
			die;
		}
		template("order_search", array(), "default/admin/order");
	}

	/**
	 * 订单高级搜索
	 * 2010/05/11 link
	 */
	public static function highsearch(){
		$search = $_GET['search'];
		$where='';
		
		if($search==1){
			$orstate = $_GET['orstates'];
			$where.="orderstate='$orstate' AND ";
		}
		if($search==2){
			$paystate = $_GET['paystates'];
			$where.="paystate='$paystate' AND orderstate=1 AND ";
		}
		if($search==3){
			$poststate = $_GET['poststates'];
			$where.="poststate='$poststate' AND orderstate=1 AND ";
		}
		if($search==4){
			$order_sn = $_GET['order_sn'];
			$email = $_GET['email'];
			$purchaser = $_GET['purchaser'];
			$address = $_GET['address'];
			$tel = $_GET['tel'];
			$posttype = $_GET['posttype'];
			$orstate = $_GET['orstate'];
			$paystate = $_GET['paystate'];
			$poststate = $_GET['poststate'];
			$consignee = $_GET['consignee'];
			$zipcode = $_GET['zipcode'];
			$mobile = $_GET['mobile'];
			$paytype = $_GET['paytype'];
			$ctime_start = $_GET['ctime_start'];
			$ctime_stop = $_GET['ctime_stop'];
			$country = $_GET['country'];    //国家
			$province = $_GET['province'];    //省份
			$city = $_GET['city'];    //市
			$county = $_GET['county'];    //县

			if($order_sn!=''){
				$where.="order_sn='$order_sn' AND ";
			}

			if($email!=''){
				$where.="email='$email' AND ";
			}

			if($purchaser!=''){
				$where.="uid='$purchaser' AND ";
			}

			if($address!=''){
				$where.="address like '%$address%' AND ";
			}

			if($tel!=''){
				$where.="tel='$tel' AND ";
			}

			if($posttype!=''){
				$where.="posttype='$posttype' AND ";
			}

			if($orstate!=''){
				$where.="orderstate='$orstate' AND ";
			}

			if($paystate!=''){
				$where.="paystate='$paystate' AND ";
			}

			if($poststate!=''){
				$where.="poststate='$poststate' AND ";
			}

			if($consignee!=''){
				$where.="consignee='$consignee' AND ";
			}

			if($zipcode!=''){
				$where.="zipcode='$zipcode' AND ";
			}

			if($mobile!=''){
				$where.="mobile='$mobile' AND ";
			}
			
			if($paytype!=''){
				$where.="paytype='$paytype' AND ";
			}

			if($ctime_start!='' && $ctime_stop!=''){
				$start=strtotime($ctime_start);
				$stop=strtotime($ctime_stop);
				$where.="createtime>='$start' AND createtime<='$stop' AND ";
			}

			if($country!=''){
				$where.="country='$country' AND ";
			}

			if($province!=''){
				$where.="province='$province' AND ";
			}

			if($city!=''){
				$where.="city='$city' AND ";
			}

			if($county!=''){
				$where.="district='$county' AND ";
			}
		}
		if($where!=''){
			$condition = substr($where,0,-4);
		}else{
			$condition = '';
		}
		$pagefile = orders::objects()->pageFilter($condition,' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
		die;
	}










	/**********************************************
	 * 跳转到添加订单
	 **********************************************/
	public static function orderAdd(){
		AdminAuth::AuthAdmin();
		$admin = AdminAuth::GetAdminId();
		if($admin==''){
			base::autoSkip("Sorry 只有管理员才能进入","正在转入","login");
			die;
		}
		if(AdminAuth::AdminCheck(72)){
			template("order_user", array(), "default/admin/order");
			die;
		}
		die;
	}

	/****************************************************
	 * 选取设置用户
	 ****************************************************/
	public static function user(){
		$uid = $_GET['userid'];
		if($uid !=0){
			$cartgoods = cartFun::getCartInfo($uid,'');
		}
		template("order_insert", array('uid'=>$uid,'cartgoods'=>$cartgoods), "default/admin/order");
	}

	/****************************************************
	 * 订单购物车商品添加页
	 ****************************************************/
	public static function insertPage(){
		$uid = $_GET['uid'];
		$cartcode = $_GET['cartcode'];
		$cartgoods = cartFun::getCart($uid,$cartcode);
		template("order_insert", array('cartcode'=>$cartcode,'uid'=>$uid,'cartgoods'=>$cartgoods), "default/admin/order");
	}

	/****************************************************
	 * 添加订单购物车商品
	 ****************************************************/
	public static function insert(){
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(72)){
			base::checkRefresh();  //防刷新
			$cartcode = $_POST['cartcode'];
			$uid = $_POST['uid'];
			$gid = $_POST['gid'];
			$gname = $_POST['gname'];
			$gsn = $_POST['gsn'];
			$count = $_POST['gcount'];
			$price = $_POST['pricevalue'];
			$act_price = $price;
			$marketprice = $_POST['marketprice'];
			$attributeid = $_POST['attributeid'];
			$attributename = $_POST['attributevalue'];
			$attributemoney = $_POST['attributemoney'];
			$check =cartFun::checkCartGoods($gid,$uid,$cartcode);    //检查购物车中是否存在此商品。
			if($check =='exist'){
				header("location:insertPage?cartcode=".$cartcode."&uid=".$uid);
				die;
			}
			$gcount = orderFun::checkGoodsCount($gid,$count);    //检查商品数量
			if($gcount){
				$isonsale = orderFun::checkGoodsIsonsale($gid);    //检测商品是否是上架商品
				if($isonsale){
					if($uid != 0){
						$rel = cartFun::cartInsert($uid,'',$gid,$gname,$gsn,$count,$price,$marketprice,$attributeid,$attributename);
					}elseif($cartcode != ''){
						$rel = cartFun::cartInsert(0,$cartcode,$gid,$gname,$gsn,$count,$price,$marketprice,$attributeid,$attributename);
					}else{
						$cartcode = cartFun::getCartNumber();
						$rel = cartFun::cartInsert(0,$cartcode,$gid,$gname,$gsn,$count,$price,$marketprice,$attributeid,$attributename);
					}
					if($rel){
						header("location:insertPage?cartcode=".$cartcode."&uid=".$uid);
					}else{
						echo 'insert no';
					}
				}else{
					echo '未上架';
				}
			}else{
				echo '库存量不足';
				//$goodsorder = goodsorder::objects()->filter("orderid='$orderid'","id");
				//template("order_insert", array('oid'=>$orderid,'goodsorder'=>$goodsorder), "default/admin/order");
			}
		}
		die;
	}

	/******************************************************
	 * 根据字段搜索用户信息
	 * 2010/05/05 link
	 ******************************************************/
	public static function getUserByField(){
		base::checkRefresh();  //防刷新
		$field = $_POST['field'];
		$userinfo = user::objects()->filter("uid='$field'||uname like '%$field%'");

		print_r(json_encode($userinfo));
		die();
	}

	/*****************************************************
	 * 根据字段搜索商品信息
	 * 2010/05/06 link
	 *****************************************************/
	public static function getGoodsByField(){
		base::checkRefresh();  //防刷新
		$field = $_POST['field'];
		$goodsinfo = goods::objects()->filter("goods_sn='$field'||goodsname like '%$field%'");

		print_r(json_encode($goodsinfo));
		die;
	}

	/**
	 * 根据商品id获取商品详细信息
	 * 2010/05/06 link
	 */
	public static function getGoodsByGid(){
		global $db;
		$gid = $_POST['gid'];
		$goods = Ware::getGoodsInfo($gid);
		$gcategory = Ware::getGoodsCategory($gid);
		$attribute = Ware::getGoodsAttribute($gid);

		$ginfo = json_encode($goods);
		$gory = json_encode($gcategory);
		$gattr = json_encode($attribute);
		print_r($ginfo.'@'.$gattr.'@'.$gory);
		die;
	}

	/*******************************************************
	 * 删除订单中的某商品
	 * 2010/05/10 link
	 *******************************************************/
	public static function del(){
		global $db;
		$oid = $_GET['orderid'];
		$gorid = $_GET['gorid'];
		$gid = $_GET['gid'];

		$rel = orderFun::delOrGoods($gorid,$gid);    //删除订单商品
		if($rel){
			orderFun::updateOrFee($oid);    //跟新订单费用
			base::autoSkip("删除成功","正在转入",URL."index.php/admin/order/detail?oid=".$oid);
		}
		die;
	}

	/********************************************************
	 * 删除订单购物车中的商品
	 ********************************************************/
	public static function cartdel(){
		$cart = $_GET['cartid'];
		$uid = $_GET['uid'];
		$cartcode = $_GET['cartcode'];
		
		$check = cartFun::checkUserCart($cart,$uid,$cartcode);    //检查购物车中的商品
		if($check){
			$rel = cartFun::delCart($cart);
			if($rel){
				base::autoSkip("删除成功","正在转入",URL."index.php/admin/order/insertPage?cartcode=".$cartcode."&uid=".$uid);
			}
		}
	}


	/************************************************
	 * 修改订单 购物车中商品数量(cart)
	 * 2010/05/10 link
	 ************************************************/
	public static function updatecount(){
		$cartid = $_GET['cartid'];
		$count = $_GET['count'];
		$uid = $_GET['uid'];
		$cartcode = $_GET['cartcode'];
		$gid = $_GET['gid'];
		$rel = cartFun::changeCartCount($cartid,$count,$uid,$cartcode,$gid);
		if($rel == 1){
			header("location:insertPage?cartcode=".$cartcode."&uid=".$uid);
		}
	}

	/***********************************************
	 * 修改订单商品的数量(order)
	 ***********************************************/
	public static function updateOrGoods(){
		$gorid = $_GET['gorid'];
		$count = $_GET['count'];
		$oid = $_GET['oid'];
		$gid = $_GET['gid'];
		$rel = orderFun::changeOrGoodsCount($gorid,$count,$oid,$gid);
		if($rel == 1){
			orderFun::updateOrFee($oid);    //跟新订单费用
			base::autoSkip("修改成功","正在转入",URL."index.php/admin/order/detail?oid=".$oid);
		}
	}

	/**********************************************
	 * 检查商品修改数量
	 **********************************************/
	public static function checkgcount(){
		$gid = $_POST['gid'];
		$count = $_POST['count'];

		$rel = orderFun::checkGoodsCount($gid,$count);
		if($rel){
			echo 'ok';
		}else{
			echo 'nocount';
		}
		die;
	}

	/*********************************************************
	 * 收货地址
	 * 2010/05/10 link
	 *********************************************************/
	public static function address(){
		$uid = $_POST['uid'];
		$cartcode = $_POST['cartcode'];
		$cheak = cartFun::checkCart($uid,$cartcode);    //判断用户购物车是否为空
		if($cheak){
			$orcode = orderFun::orderCode($uid);    //获取订单编号
			$oid = orderFun::makeOrder($orcode,$uid);    //生成订单
			$rel = orderFun::makeOrGoods($oid,$uid,$cartcode);    //添加订单商品
			if($rel){
				orderFun::updateOrFee($oid);    //跟新订单费用
				header("location:addrPage?oid=".$oid);
			}
			
		}else{
			base::autoSkip("请选择商品","正在转入",URL);
		}
	}
	
	/********************************************************
	 * 收获地址跳转  订单添加成功跳转到收货地址页
	 ********************************************************/
	public static function addrPage(){
		$oid = $_GET['oid'];
		template("order_address", array('oid'=>$oid), "default/admin/order");
	}

	/*******************************************************
	 * 收货地址添加
	 *******************************************************/
	public static function addrInsert(){
		$oid = $_POST['oid'];
		$consignee = $_POST['consignee'];
		$province = $_POST['province'];
		$city = $_POST['city'];
		$county = $_POST['county'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$postboat = $_POST['postboat'];
		$phone = $_POST['phone'];
		$tel = $_POST['tel'];
		$sign = $_POST['sign'];
		$optimaltime = $_POST['optimaltime'];
		$paytype = $_POST['paytype'];
		$consigntype = $_POST['consigntype'];
		$stock = $_POST['stock'];
		//echo "订单id:".$oid."支付方式：".$paytype." 收货方式：".$consigntype." 库存不足：".$stock;

		$order = new orders();
		$order -> id = $oid;
		$order -> tel = $tel;
		$order -> mobile = $phone;
		$order -> email = $email;
		$order -> besttime = $optimaltime;
		$order -> paytype = $paytype;
		$order -> posttype = $consigntype;
		$order -> consignee = $consignee;
		$order -> zipcode = $postboat;
		$order -> province = $province;
		$order -> city = $city;
		$order -> district = $county;
		$order -> address = $address;
		$order -> howdo = $stock;
		$rel = $order -> save();
		if($rel){
			template("order_cue", array('oid'=>$oid), "default/admin/order");
		}
	}

	/*************************************************
	 * 订单详情
	 * 2010/05/11 link
	 *************************************************/
	public static function detail(){
		global $db;

		$oid = $_GET['oid'];
		$orinfo = orders::objects()->filter("id='$oid'");
		$userinfo = user::objects()->filter("uid=".$orinfo[0]->uid);
		$goinfo = goodsorder::objects()->filter("orderid='$oid'");
		$orderaction = orderaction::objects()->filter("orderid='$oid'");
		try{
			$sql = "SELECT oa.action,oa.orderstate,oa.paystate,oa.poststate,oa.note,oa.operationtime,ai.uname FROM `orderaction` oa JOIN admininfo ai ON ai.id=oa.actionuser WHERE orderid='$oid'";
			$rs = $db ->prepare($sql);
			$rs->execute();
			$orderaction = $rs->fetchAll();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$orderaction = '';
		}
		//print_r($orderaction);
		template("order_detail", array('orinfo'=>$orinfo,'userinfo'=>$userinfo,'goinfo'=>$goinfo,'orderaction'=>$orderaction), "default/admin/order");
	}
	
	
	/********************************************************
	 * 更改订单状态
	 * 2010/05/12 link
	 ********************************************************/
	public static function state(){
		global $db;
		base::checkRefresh();  //防刷新
		AdminAuth::AuthAdmin();
		$admin = AdminAuth::GetAdminId();
		if(AdminAuth::AdminCheck(73)){
			$oid = $_POST['oid'];
			$sta = $_POST['sta'];
			$pstate = $_POST['pstate'];
			$poststate = $_POST['poststate'];
			$remark = $_POST['remark'];
			$action = $_POST['act'];
			//echo $oid.' '.$sta.' '.$remark;

			if($action==1){
				$rel = orderFun::updateOrderState($oid,$sta);
			}
			if($action==2){
				$rel = orderFun::updateOrderPaystate($oid,$pstate);
			}
			if($action==3){
				$rel = orderFun::updateOrderPoststate($oid,$poststate);
			}
			
			if($rel){
				if($action==3 && $poststate==2){
					orderFun::upAmount($oid);
				}
				if($action==1 && $sta ==3){
					$orinfo = orderFun::getOrderInfo($oid);
					if($orinfo->uid !=0){
						orderFun::setIntegral($orinfo->uid,$orinfo->integral);    //成功订单赠积分3
						orderFun::coupon($orinfo->ticket,$orinfo->uid);    //成功订单赠优惠券
					}

				}
				/*if($action==1 && $sta==3){
					$orinfo = orderFun::getOrderInfo($oid);
					if($orinfo->uid!=0){
						$goinfo = goodsorder::objects()->filter("orderid='$oid'");
						foreach($goinfo as $item){
							$typ = orderFun::getGlobalPromotion(3);    //送积分
							if($typ){
								$integral = orderFun::integral($orinfo->uid,$orinfo->goodsmount,$typ->id);
							}else{
								$lar = orderFun::getPromotion($item->goodsid);
								if($lar){    //送积分
									foreach ($lar as $itm){
										if($itm->activity_type==3){
											$integral = orderFun::integral($orinfo->uid,$orinfo->goodsmount,$itm->id);
										}
									}
								}
							}
							$typ = orderFun::getGlobalPromotion(4);    //送优惠券
							if($typ){
								$stoptime = time()+(USEFUL_LIFE*24*60*60);
								$cheap = orderFun::cheap($orinfo->uid,$orinfo->goodsmount,$typ->id,$stoptime);
							}else{
								$lar = orderFun::getPromotion($item->goodsid);
								if($lar){    //送优惠券
									foreach ($lar as $itm){
										if($itm->activity_type==4){
											$stoptime = time()+(USEFUL_LIFE*24*60*60);
											$cheap = orderFun::cheap($orinfo->uid,$orinfo->goodsmount,$itm->id,$stoptime);
										}
									}
								}
							}
						}
					}
				}*/
				$oaction = new orderaction();
				$oaction -> orderid = $oid;
				$oaction -> actionuser = $admin;
				$oaction -> action = $action;
				$oaction -> orderstate = $sta;
				$oaction -> paystate = $pstate;
				$oaction -> poststate = $poststate;
				$oaction -> note = $remark;
				$oaction -> operationtime = time();
				$re = $oaction -> save();
				if($re){
					$orinfo = orders::objects()->filter("id='$oid'");
					$userinfo = user::objects()->filter("uid=".$orinfo[0]->uid);
					$goinfo = goodsorder::objects()->filter("orderid='$oid'");
					$orderaction = orderaction::objects()->filter("orderid='$oid'");
					try{
						$sql = "SELECT oa.action,oa.orderstate,oa.paystate,oa.poststate,oa.note,oa.operationtime,ai.uname FROM `orderaction` oa JOIN admininfo ai ON ai.id=oa.actionuser WHERE orderid='$oid'";
						$rs = $db ->prepare($sql);
						$rs->execute();
						$orderaction = $rs->fetchAll();
						$rs->closeCursor();
					} catch (DZGException $e) {
						$orderaction = '';
					}
					template("order_detail", array('orinfo'=>$orinfo,'userinfo'=>$userinfo,'goinfo'=>$goinfo,'orderaction'=>$orderaction), "default/admin/order");
				}
			}
			die;
		}
	}

	/**********************************************
	 * 订单费用信息修改
	 **********************************************/
	public static function fee(){
		$oid = $_GET['oid'];
		$cardfee = $_GET['cardfee'];
		$tax = $_GET['tax'];
		$postfee = $_GET['postfee'];
		$packagefee = $_GET['packagefee'];
		$rel = orderFun::updateFee($oid,$cardfee,$tax,$postfee,$packagefee);
		if($rel){
			base::autoSkip("修改成功","正在转入","detail?oid=".$oid);
		}
	}

	/************************************************
	 * 更改发票信息
	 ************************************************/
	public static function fpsave(){
		$oid = $_GET['oid'];
		$fpty = $_GET['fpty'];
		$fphead = $_GET['fphead'];
		$fpcont = $_GET['fpcont'];
		$order = new orders();
		$order ->id = $oid;
		$order ->invoicetype = $fpty;
		$order ->invoicehead = $fphead;
		$order ->invoicecontent = $fpcont;
		$rel = $order ->save();
		if($rel){
			base::autoSkip("修改成功","正在转入","detail?oid=".$oid);
		}else{
			base::autoSkip("修改失败","正在转入","detail?oid=".$oid);
		}
	}

	/****************************************************
	 * 显示收货信息 - 修改
	 * 2010/05/13 link
	 ****************************************************/
	public static function addr_sel(){
		$oid = $_GET['oid'];
		$orinfo = orders::objects()->filter("id='$oid'");

		template("addr_sel", array('orinfo'=>$orinfo), "default/admin/order");
		die;
	}

	/****************************************************
	 * 收货地址-更改
	 * 2010/05/13 link
	 ****************************************************/
	public static function addr_update(){
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(73)){
			$oid = $_POST['oid'];
			$consignee = $_POST['consignee'];
			$email = $_POST['email'];
			$address = $_POST['address'];
			$postboat = $_POST['postboat'];
			$phone = $_POST['phone'];
			$tel = $_POST['tel'];
			$sign = $_POST['sign'];
			$optimaltime = $_POST['optimaltime'];
			$province = $_POST['province'];
			$city = $_POST['city'];
			$county = $_POST['county'];

			$order = new orders();
			$order->id = $oid;
			$order->consignee = $province;
			$order->city = $city;
			$order->district = $county;
			$order->province = $province;
			$order->email = $email;
			$order->zipcode = $postboat;
			$order->tel = $tel;
			$order->mobile = $phone;
			$order->besttime = strtotime($optimaltime);
			$order->address = $address;
			$rel = $order->save();
			if($rel){
				base::autoSkip("修改成功","正在转入","detail?oid=".$oid);
			}
			die;
		}
	}
	
	/**
	 * 移除订单
	 * 2010/05/13 link
	 */
	public static function drop(){
		AdminAuth::AuthAdmin();
		if(AdminAuth::AdminCheck(74)){
			$oid = $_GET['oid'];
			$orinfo=orders::objects()->filter("id='$oid'");
			$order = new orders();
			$order -> id = $oid;
			$rel = $order -> delete();
			if($rel){
				$order_drop = new order_drop();
				$order_drop -> oid =$orinfo[0]->id;
				$order_drop -> order_sn =$orinfo[0]->order_sn;
				$order_drop -> orderstate =$orinfo[0]->orderstate;
				$order_drop -> paystate =$orinfo[0]->paystate;
				$order_drop -> poststate =$orinfo[0]->poststate;
				$order_drop -> uid =$orinfo[0]->uid;
				$order_drop -> consignee =$orinfo[0]->consignee;
				$order_drop -> country =$orinfo[0]->country;
				$order_drop -> province =$orinfo[0]->province;
				$order_drop -> city =$orinfo[0]->city;
				$order_drop -> district =$orinfo[0]->district;
				$order_drop -> address =$orinfo[0]->address;
				$order_drop -> zipcode =$orinfo[0]->zipcode;
				$order_drop -> tel =$orinfo[0]->tel;
				$order_drop -> mobile =$orinfo[0]->mobile;
				$order_drop -> email =$orinfo[0]->email;
				$order_drop -> besttime =$orinfo[0]->besttime;
				$order_drop -> paytype =$orinfo[0]->paytype;
				$order_drop -> posttype =$orinfo[0]->posttype;
				$order_drop -> createtime =$orinfo[0]->createtime;
				$order_drop -> howdo =$orinfo[0]->howdo;
				$order_drop -> paytime =$orinfo[0]->paytime;
				$order_drop -> confirmtiem =$orinfo[0]->confirmtiem;
				$order_drop -> posttime =$orinfo[0]->posttime;
				$order_drop -> accepttime =$orinfo[0]->accepttime;
				$order_drop -> invoicetype =$orinfo[0]->invoicetype;
				$order_drop -> goodsmount =$orinfo[0]->goodsmount;
				$order_drop -> postfee =$orinfo[0]->postfee;
				$order_drop -> packagefee =$orinfo[0]->packagefee;
				$order_drop -> tax =$orinfo[0]->tax;
				$order_drop -> cardid =$orinfo[0]->cardid;
				$order_drop -> cardfee =$orinfo[0]->cardfee;
				$order_drop -> pay =$orinfo[0]->pay;
				$order_drop -> operator =$orinfo[0]->operator;
				$drop = $order_drop -> save();
				if($drop){
					base::autoSkip("移除成功","正在转入","orlist");
				}
			}
			die;
		}
	}

	/**
	 * 缺货记录
	 */
	public static function OOS(){
		$sql = "SELECT g.id,g.goods_sn,g.goodsname,g.leavingcount,g.pid,g.sid,p.pname,s.suppliername FROM goods g JOIN producer p ON g.pid=p.id JOIN suppliers s ON g.sid=s.id WHERE g.leavingcount=0";
		$pagefile = orders::objects()->pageFilter("",' createtime desc ',2,$sql);
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$ginfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);

		template("oos", array('ginfo'=>$ginfo,'page'=>$html), "default/admin/order");
		die;
	}

	/**
	 * 未支付
	 */
	public static function nopayment(){
		$pagefile = orders::objects()->pageFilter("orderstate=1 AND paystate=0",' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
	}

	/**
	 * 已付款
	 */
	public static function paymented(){
		$pagefile = orders::objects()->pageFilter("orderstate=1 AND paystate=1",' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
	}

	/**
	 * 已发货
	 */
	public static function consigned(){
		$pagefile = orders::objects()->pageFilter("orderstate=1 AND poststate=2",' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
	}

	/**
	 * 未发货
	 */
	public static function noconsign(){
		$pagefile = orders::objects()->pageFilter("orderstate=1 AND poststate=0",' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
	}

	/**
	 * 配货中
	 */
	public static function wait(){
		$pagefile = orders::objects()->pageFilter("orderstate=1 AND poststate=1",' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
	}

	/**
	 * 无效订单
	 */
	public static function futility(){
		$pagefile = orders::objects()->pageFilter("orderstate=0",' createtime desc ');
		$page = new pagination($pagefile,PAGE_SIZE,$_GET['page']);
		$orinfo = $page->objectList();
		$url = base::getUrl();
		$html = $page->getHtml($url);
		
		template("order_list", array('orinfo'=>$orinfo,'page'=>$html), "default/admin/order");
	}

}
?>