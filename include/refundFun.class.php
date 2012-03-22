<?php
class refundFun {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}

	/****************************************
	 * 退款列表
	 ****************************************/
	public static function refundSel(){
		try{
			return refund::objects()->filter("");
		} catch (Exception $e) {
			return array();
		}
	}

	/*****************************************
	 * 更改退款状态
	 * @param int $refid 退款申请id
	 *****************************************/
	public static function refundState($refid,$state){
		$refund = new refund();
		$refund -> id = $refid;
		$refund -> state = $state;
		$rel = $refund -> save();
		if($rel){
			return true;
		}else{
			return false;
		}
	}
}
?>