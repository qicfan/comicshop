<?php
class refundFun {
	/**
	 * ��ֹʵ����
	 */
	private function __construct() {
	}

	/****************************************
	 * �˿��б�
	 ****************************************/
	public static function refundSel(){
		try{
			return refund::objects()->filter("");
		} catch (Exception $e) {
			return array();
		}
	}

	/*****************************************
	 * �����˿�״̬
	 * @param int $refid �˿�����id
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