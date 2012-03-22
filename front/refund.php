<?php
/**
 * 退款申请
 */
//header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';

class refundViews{
	/**
	 * 用户提交 举报
	 */
	public static function index() {
        auth::authUser();   // 用户验证       
		 
		$accountname = isset($_POST['accountname'])?htmlspecialchars( $_POST['accountname'], ENT_QUOTES ):'';
		$refundname = isset($_POST['refundname'])?htmlspecialchars( $_POST['refundname'], ENT_QUOTES ):'';
		$remark = isset($_POST['remark'])?htmlspecialchars( $_POST['remark'], ENT_QUOTES ):'';
		//$amount = floatval( $_POST['amount']);
		$bankcard = isset($_POST['bankcard'])?htmlspecialchars( $_POST['bankcard'], ENT_QUOTES ):'';
		$orderid = isset($_POST['orderid'])?htmlspecialchars( $_POST['orderid'], ENT_QUOTES ):0;
		$openingbank = isset($_POST['openingbank'])?htmlspecialchars( $_POST['openingbank'], ENT_QUOTES ):0;
		$bank = isset($_POST['bank'])?$_POST['bank']:'';
		$gid = isset($_GET['gid'])?intval( $_GET['gid'] ):'';
		$uid = auth::getUserId();
		$id = isset($_GET['id'])?intval( $_GET['id'] ):'';
		$type = isset($_POST['type'])?intval($_POST['type']):0;
		$seccode = isset($_POST['seccode'])?$_POST['seccode']:0;
		if ($orderid==0 || $bankcard=='') {
			$uname = auth::getUserName();
			$page = isset($_GET['page'])?intval($_GET['page']):1;
			$manager = refund::objects()->pageFilter("uid = $uid", 'id DESC');  //按id倒序排列
			$refund = new pagination($manager, PAGE_SIZE, $page);  //分页
			$count=$refund->dataCount;
			$navigation = NAV_MY . '> <a>退款申请</a>';
			template("refund", array('refund'=>$refund,'page'=>$page,'uname'=>$uname,'count'=>$count,'navigation'=>$navigation), 'default/front/refund');
			exit();
		}

		if ( strtoupper($seccode) != strtoupper($_SESSION['seccode']) ) {
			core::alert('验证码错误');
			exit();
		}
		//if(empty($orderid)) core::alert('订单号不能为空！');

		$sql = "select pay from orders where order_sn='$orderid'";             // 查找订单号
		$payarr = question::objects()->QuerySql($sql);
        if(empty($payarr)) {
			core::alert('订单号不存在！请查证后再申请');
			exit();
		}

        $amount = (empty($payarr['0']['pay']))?0:$payarr['0']['pay'];

		base::checkRefresh();  //防刷新
		$time = time();
		//数据库
		$refund = new refund();
							
		$refund->id = $id;
		$refund->uid = $uid;
		$refund->type = $type;
		$refund->bank = $bank;
		$refund->remark = $remark;
		$refund->amount = $amount;
		$refund->bankcard = $bankcard;
		$refund->orderid = $orderid;
		$refund->refundtime = $time;
        $refund->refundname = $refundname;
		$refund->openingbank = $openingbank;
		$refund->accountname = $accountname;
		$refund->state = 0;

		$rs = $refund->save();
		
		if ($rs){
			core::alert('提交成功！');
		}else {
			core::alert('提交失败！');
		}
		
	}
	public static function checkOid($oid=''){
		$oid = ($oid)?$oid:$_GET['oid'];
		try {
			orders::objects()->get("order_sn = '$oid'");
			die('1');
		} catch (Exception $e) {

		}
		
        die('0');
	}

}