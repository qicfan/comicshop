<?php
if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/goods.class.php';
require_once PRO_ROOT . 'include/orderFun.class.php';
require_once PRO_ROOT . 'include/cartFun.class.php';
require_once PRO_ROOT . 'include/cheapFun.class.php';
class orderViews{
	/*******************************************
	 * 订单信息
	 *******************************************/
	public static function orinfo(){
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$cartcode = '';
			$consign = orderFun::getConsign($uid,0);
			$zjconsign = orderFun::getConsign($uid,1);
			$cheapticket = cheapFun::getUserTicket($uid);
		}else{
			$uid = 0;
			$cartcode = $_COOKIE['cart'];
			$consign = null;
			if(isset($_COOKIE['consigninfo'])){
				$zjconsign = $_COOKIE['consigninfo'];
			}else{
				$zjconsign = null;
			}
			$cheapticket = null;
		}
		$cart = cartFun::getCart($uid,$cartcode);
		foreach ($cart as $itm){
			$ginfo = Ware::GetOne($itm->goodsid);
			if($ginfo){
				$itm->pic=$ginfo->imgcurrent;
			}
		}
		if($cart==''){
			base::autoSkip("sorry 订单中无商品，请购买！","正在转入",URL."index.php/front/cart/cartSelect");
			die;
		}
		$check = orderFun::checkCartGoodsCount($uid,$cartcode);    //检查购物车中商品的数量
		if($check ==1 ){
			template("ddxx", array('consign'=>$consign,'zjconsign'=>$zjconsign,'cart'=>$cart,'cheapticket'=>$cheapticket), "default/front/order");
			die;
		}else{
			$str = "Sorry, 您购买的商品库存量不足。请修改后提交。\\n";
			foreach ($check as $itm){
				$str.="商品【".$itm['gname']."】库存量不足，最大购买量为".$itm['leavingcount']."\\n";
			}
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
			echo "<script>alert('".$str."');window.location.href='".URL."index.php/front/cart/cartSelect';</script>";
			die;
		}
		die;
	}

	/** 常用地址添加 */
	public static function infoAdd(){
		auth::authUser();
		$login = auth::isUserLogin();    //判断用户是否登录
		$uid = auth::getUserId();
		if($login){
			$consigner = $_POST['consigner'];
			$tel = $_POST['tel'];
			$addr = $_POST['addr'];
			$zip = $_POST['zip'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$s1 = $_POST['province'];
			$s2 = $_POST['city'];
			$s3 = $_POST['county'];
			$rel = orderFun::addConsign($uid,$consigner,$addr,$zip,$tel,$phone,$email,$s1,$s2,$s3);
			if($rel){
				echo $rel;
			}else{
				echo 'error';
			}
		}else{
			base::autoSkip("sorry 只有登录用户才可添加常用地址！","正在转入",URL."index.php/front/order/orinfo");
		}
	}

	/** 地址保存，即最近使用的地址 */
	public static function infoSave(){
		$consigner = $_POST['consigner'];
		$tel = $_POST['uptel'];
		$addr = $_POST['upaddr'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$email = $_POST['upemail'];
		$s1 = $_POST['province'];
		$s2 = $_POST['city'];
		$s3 = $_POST['county'];
		//auth::authUser();
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){    //如果登录
			$uid = auth::getUserId();
			$rel = orderFun::saveConsign($uid,$consigner,$addr,$zip,$tel,$phone,$email,$s1,$s2,$s3);
			if($rel){
				echo 'ok';
			}
		}else{
			$arry = array('consigner'=>$consigner,'addr'=>$addr,'province'=>$s1,'city'=>$s2,'district'=>$s3,'zipcode'=>$zip,'tel'=>$phone,'mobile'=>$tel,'email'=>$email);
			setcookie('consigninfo',$arry);
			echo 'ok';
		}
	}

	/** 常用地址删除 */
	public static function infodel(){
		$conid = $_POST['conid'];
		$rel = orderFun::delConsign($conid);
		if($rel){
			echo 'ok';
		}
	}

	/*************************************************
	 * 生成订单
	 *************************************************/
	public static function makeOrder(){
		$consigner = $_POST['consigner'];
		$tel = $_POST['tel'];
		$addr = $_POST['addr'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$s1 = $_POST['pro'];
		$s2 = $_POST['city'];
		$s3 = $_POST['county'];


		$payty = $_POST['payty'];     //配送方式
		$paytyp = $_POST['paytyp'];    //支付方式
		$ztaddr = $_POST['ztaddr'];    //自提地点
		$yunfee = $_POST['yunfee'];    //运费
		$zttime = $_POST['zttime'];    //自提时间

		$fpty = $_POST['fplx'];    //发票类型
		$fptt = $_POST['fptaitou'];    //发票抬头
		$fpcontent = $_POST['fpnr'];    //发票内容

		$remark = $_POST['remark'];
		$tickid = $_POST['tickid'];
		$tickmoney = $_POST['tickmoney'];
		$besttime = $_POST['furl'];

		if($consigner!='' && $addr !='' && $zip !=''  && ($phone !='' || $tel !='')){
			$login = auth::isUserLogin();    //判断用户是否登录
			if($login){
				$uid = auth::getUserId();
				$cartcode = '';
			}else{
				$uid =0;
				if(isset($_COOKIE['cart'])){
					$cartcode = $_COOKIE['cart'];
				}
			}
			$orcode = orderFun::orderCode($uid);    //获取订单编号
			$cart = cartFun::getCart($uid,$cartcode);    //获取购物车信息，即判断购物车是否为空
			if(!$cart){
				base::autoSkip("购物车中无商品","正在转入",URL."index.php/front/cart/cartSelect",3);
				die;
			}
			$check = orderFun::checkCartGoodsCount($uid,$cartcode);    //检查购物车中商品的数量
			if($check != 1){
				base::autoSkip("购物车中的商品库存量不足","正在转入",URL."index.php/front/cart/cartSelect",3);
				die;
			}
			$oid = orderFun::makeOrder($orcode,$uid,$cartcode);    //生成订单
			if($oid){
				$rel = orderFun::orderConsign($oid,$consigner,$tel,$addr,$zip,$phone,$email,$s1,$s2,$s3,$payty,$paytyp,$ztaddr,$yunfee,$zttime,$fpty,$tptt,$fpcontent,$remark,$tickid,$tickmoney,$besttime);    //添加收货人信息

				$ord = orderFun::makeOrGoods($oid,$uid,$cartcode);    //添加订单商品
				if($paytyp == 1){
					header("location:".URL."index.php/front/order/orderSuc?oid=$oid");
				}
				if($paytyp == 0){
					header("location:".URL."index.php/front/pay/orpay?oid=$oid");
				}
			}else{
				base::autoSkip("操作失败","正在转入",URL."index.php");
			}
		}else{
			base::autoSkip("收货信息不明，请填写清楚！","正在转入",URL."index.php/front/order/orinfo");
		}
	}

	/*****************************************************
	 * 订单生成成功跳转
	 *****************************************************/
	public static function orderSuc(){
		$oid = $_GET['oid'];
		$orinfo = orderFun::getOrderInfo($oid);
		$orcode = $orinfo ->order_sn;
		$ormoney = orderFun::getOrderMoney($oid);
		template("order_suc", array('oid'=>$oid,'ormoney'=>$ormoney,'orcode'=>$orcode), "default/front/order");
	}

	public static function myOrder(){
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$myor = orderFun::getMyOrder($uid);
		}else{
			$myor = orderFun::getMyOrder(0);
		}
		template("myorder", array('myorder'=>$myor), "default/front/order");
	}

	/*******************************************
	 * 删除订单信息页中的商品
	 *******************************************/
	public static function delorcart(){
		$cart = $_GET['cartid'];
		$login = auth::isUserLogin();
		if($login){
			$uid = auth::getUserId();
			$ch = cartFun::checkCartGd($cart,$uid,'');
		}else{
			$ch = cartFun::checkCartGd($cart,0,$_COOKIE['cart']);
		}
		if($ch){
			$rel = cartFun::delCart($cart);
			if($rel){
				header("location:".URL."index.php/front/order/orinfo");  
			}else{
				base::autoSkip("sorry 删除失败！","正在转入",URL."index.php/front/order/orinfo");
			}
		}
	}
}
?>