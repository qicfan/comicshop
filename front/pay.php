<?php
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'include/orderFun.class.php';
require_once PRO_ROOT . 'include/payFun.class.php';
require_once PRO_ROOT . 'models.php';

class payViews{
	/***********************************
	 * 支付
	 ***********************************/
	public static function orpay(){
		$oid = $_GET['oid'];
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
		}else{
			$uid =0;
		}
		
		$orinfo =orderFun::getOrderInfo($oid);
		$orderId = $orinfo->order_sn;
		$key = PAYKEY;
		$payerId = $uid;
		if($orinfo ->freight==0 ){
			$orderAmount =$orinfo->goodsmount+$orinfo->postfee+$orinfo->packagefee+$orinfo->tax-$orinfo->cardfee; 
		}
		if($orinfo ->freight ==1){
			$orderAmount =$orinfo->goodsmount+$orinfo->packagefee+$orinfo->tax-$orinfo->cardfee; 
		}
		if($orderAmount<0){
			$orderAmount=0;
		}
		$orderTime = time();
		$rtnUrl	= "http://10.69.10.9/comicyu/comic_mall/trunk/src/index.php/front/pay/payJump";
		$signMsg = md5($orderId.$key.$payerId.$orderAmount.$orderTime.$rtnUrl);

		/*if(isset($_COOKIE['viewgoods'])){    //最近浏览过的商品
			$viewgoods = $_COOKIE['viewgoods'];
			print_r($viewgoods);
		}*/

		template("zxzf", array('orderId'=>$orderId,'oid'=>$oid,'key'=>$key,'payerId'=>$payerId,'orderAmount'=>$orderAmount,'orderTime'=>$orderTime,'rtnUrl'=>$rtnUrl,'signMsg'=>$signMsg), "default/front/order");
	}

	/*************************************
	 * 支付完成跳转
	 *************************************/
	public static function payJump(){		
		$orderId = $_POST['orderId'];
		$rtnResult = $_POST['rtnResult'];
		$errorMsg = $_POST['errorMsg'];
		$payerId = $_POST['payerId'];
		$orderAmount = $_POST['orderAmount'];
		$rtnTime = $_POST['rtnTime'];
		$signMsg = $_POST['signMsg'];
		$check = md5($orderId.PAYKEY.$rtnResult.$errorMsg.$payerId.$orderAmount.$rtnTime);
		if($check ==$signMsg){
			if($rtnResult == 1){
				$oid = orderFun::getOidByOrderSn($orderId);
				$rel = orderFun::updateOrderPaystate($oid,1,$rtnTime);
				$pay = payFun::payRecordInsert($payerId,$orderId,$pay_sn,$orderAmount,$rtnTime);
				if($rel){
					echo "支付成功！";
				}
			}
			if($rtnResult == 2){
				echo "支付失败";
			}
		}
	}

	/***************************************
	 * 支付时判断账号余额
	 ***************************************/
	public static function accountM(){
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$key = PAYKEY;
			$signMsg = md5($uid.$key);
			$linkUrl = PAYURL."index.php/pay/mall?act=4&accountId=".$uid."&signMsg=".$signMsg;
			$rtnVal = file_get_contents($linkUrl);
			//error1账户空缺,error2签名错误,error3无此帐号
			if($rtnVal != 'error1' && $rtnVal != 'error2' && $rtnVal != 'error3'){
				echo $rtnVal;
			}else{
				echo 'orror';
			}
		}else{
			echo 'logon';
		}
	}

	/**********************************************
	 * 退款
	 * 根据订单编号获取支付记录->退款->商品数量还原
	 **********************************************/
	/*public static function returnMoney(){
		$ordercode = $_GET['ordercode'];
		$rel = payFun::payRecordSel($ordercode);
		if($rel){
			$orderId = $rel -> ordercode;
			$payerId = $rel -> uid;
			$orderAmount = $rel -> payfee;
			$orderTime = time();
			$signMsg = md5($orderId.PAYKEY.$payerId.$orderAmount.$orderTime);
			$linkUrl = PAYURL."index.php/pay/mall?act=3&orderId=".$orderId."&payerId=".$payerId."&orderAmount=".$orderAmount."&orderTime=".$orderTime."&signMsg=".$signMsg;
			$rtnVal=file_get_contents($linkUrl);
			if($rtnVal==1){
				orderFun::revertGoodsCount($ordercode);    //退款成功，还原商品数量。
				echo '退款成功';
			}elseif($rtnVal==2){
				echo '退款失败';
			}
		}
	}*/


}
?>