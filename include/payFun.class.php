<?php
class payFun{
	/*********************************************
	 * 添加支付记录
	 * @param int $uid 用户id
	 * @param string $ordercode 订单编号
	 * @param string $pay_sn 支付账号
	 * @param float $payfee 支付金额
	 * @param int $paytime 支付时间
	 *********************************************/
	public static function payRecordInsert($uid,$ordercode,$pay_sn,$payfee,$paytime){
		$paycode = new payrecord();
		$paycode ->uid =$uid;
		$paycode ->ordercode = $ordercode;
		$paycode ->pay_sn = $pay_sn;
		$paycode ->payfee = $payfee;
		$paycode ->paytime = $paytime;
		return $paycode ->save();	
	}

	/*********************************************
	 * 获取支付记录
	 * @param string $ordercode 订单编号
	 *********************************************/
	public static function payRecordSel($ordercode){
		try{
			$rel = payrecord::objects()->get("ordercode='$ordercode'");
		}catch(Exception $e){
			return false;
		}
		return $rel;
	}
}
?>