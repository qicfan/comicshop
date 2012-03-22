<?php
require_once DZG_ROOT . '/core/models.php';

//会员
class user extends models {
	public $id = '';
	public $uid = '';
	public $uname = '';
	public $member = '';
	public $mobile = '';
	public $address = '';
	public $email = ''; 
	public $fullname = ''; 
	public $type = ''; 
	public $sex = ''; 
	public $birthday = ''; 
	public $province = ''; 
	public $city = ''; 
	public $district = ''; 
	public $idcard = ''; 
	public $phone = ''; 
	public $zipcode = ''; 
	public $remark = '';
	public $headpic = '';
	public $lastlogintime = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//管理员的信息
class admininfo extends models {
	public $id = '';
	public $realname = '';
	public $uname = '';
	public $password = '';
	public $email = '';
	public $actionlist = '';
	public $des = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//管理员日志
class adminlog extends models {
	public $id = '';
	public $adminid = '';
	public $logcontent = '';
	public $logtime = '';
	public $ip = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//管理员权限列表
class adminpermission extends models {
	public $id = '';
	public $parentid = '';
	public $actionname = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//新闻
class article extends models {
	public $id = '';
	public $title = '';
	public $adminid = '';
	public $sort = '';
	public $state = '';
	public $createtime = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//新闻分类
class articlecategory extends models {
	public $id = '';
	public $parentid = '';
	public $sortname = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//评论
class comment extends models {
	public $id = '';
	public $title = '';
	public $uid = '';
	public $uname='';
	public $ulevel='';
	public $goodsid = '';
	public $score = '';
	public $good = '';
	public $bad = '';
	public $summary = '';
	public $createtime = '';
	public $ip = '';
	public $verify = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//评论的回复
class comment_reply extends models {
	public $id = '';
	public $commentid = '';
	public $uid = '';
	public $uname='';
	public $reply = '';
	public $replytime = '';
	public $verify='0';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//用户提问
class question extends models {
	public $id = '';
	public $uid = '';
	public $gid = '';
	public $aid = '';
	public $type ='';
	public $uname ='';
	public $title = '';
	public $state = '';
	public $content = '';
	public $reply = '';
	public $questiontime = '';
	public $replytime = '';
	public $verify = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//价格举报
class inform extends models {
	public $id = '';
	public $uid = '';
	public $gid = '';
	public $aid = '';
	public $url = '';
	public $state = '';
	public $content = '';
	public $reply = '';
	public $questiontime = '';
	public $replytime = '';
	public $verify = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//退款申请
class refund extends models {
	public $id = '';
	public $uid = '';
	public $type = '';
	public $amount = '';
	public $orderid = '';
	public $refundtime = '';
	public $state = '';
	public $refundname = '';
	public $accountname = '';
	public $bankcard = '';
	public $openingbank = '';
	public $bank = '';
	public $remark = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}


//优惠券
class coupon extends models {
	public $id = '';
	public $code = '';
	public $fee = '';
	public $starttime = '';
	public $deadline = '';
	public $state = '';
	public $uid = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//是否启用验证码
class authcode extends models {
	public $id = '';
	public $isreg = '';
	public $islogin = '';
	public $iscomment = '';
	public $isquestion = '';
	public $isloginman = '';
	public $codewidth = '';
	public $codeheight = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//友情链接
class friendship extends models {
	public $id = '';
	public $title = '';
	public $linkurl = '';
	public $sort = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//关键字过滤
class wordfilter extends models {
	public $id = '';
	public $source = '';
	public $replace = '';
	
	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//订单
class orders extends models {
	public $id = '';
	public $order_sn = '';
	public $orpart = '';
	public $orderstate = '';
	public $paystate = '';
	public $poststate = '';
	public $uid = '';
	public $consignee = '';
	public $country = '';
	public $province = '';
	public $city = '';
	public $district = '';
	public $address = '';
	public $zipcode = '';
	public $tel = '';
	public $mobile = '';
	public $email  = '';
	public $besttime = '';
	public $paytype	 = '';
	public $posttype = '';
	public $createtime = '';
	public $howdo = '';
	public $paytime = '';
	public $confirmtiem = '';
	public $posttime = '';
	public $accepttime = '';
	public $invoicetype = '';
	public $goodsmount = '';
	public $postfee = '';
	public $packagefee = '';
	public $tax = '';
	public $cardid = '';
	public $cardfee = '';
	public $pay = '';
	public $integral = '';
	public $operator = '';
	public $freight = '';
	public $ticket = '';
	public $cheap = '';
	public $zttime = '';
	public $ztaddr = '';
	public $invoicehead = '';
	public $invoicecontent = '';
	public $remark = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

class order_drop extends models {
	public $id = '';
	public $oid = '';
	public $order_sn = '';
	public $orderstate = '';
	public $paystate = '';
	public $poststate = '';
	public $uid = '';
	public $consignee = '';
	public $country = '';
	public $province = '';
	public $city = '';
	public $district = '';
	public $address = '';
	public $zipcode = '';
	public $tel = '';
	public $mobile = '';
	public $email  = '';
	public $besttime = '';
	public $paytype	 = '';
	public $posttype = '';
	public $createtime = '';
	public $howdo = '';
	public $paytime = '';
	public $confirmtiem = '';
	public $posttime = '';
	public $accepttime = '';
	public $invoicetype = '';
	public $goodsmount = '';
	public $postfee = '';
	public $packagefee = '';
	public $tax = '';
	public $cardid = '';
	public $cardfee = '';
	public $pay = '';
	public $operator = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

class orderaction extends models {
	public $id = '';
	public $orderid = '';
	public $actionuser = '';
	public $action ='';
	public $orderstate = '';
	public $paystate = '';
	public $poststate = '';
	public $note = '';
	public $operationtime = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

class cart extends models {
	public $id = '';
	public $cartnumber = '';
	public $uid = '';
	public $goodsid = '';
	public $goods_sn = '';
	public $goodsname = '';
	public $shoppirce = '';
	public $mprice = '';
	public $marketprice = '';
	public $goodscount = '';
	public $attributeid = '';
	public $attributename = '';
	public $cheap = '';
	public $mark = '';
	public $carttime = '';
	public $largess = '';
	public $ticket = '';
	public $freight = '';
	public $host = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//商品
class goods extends models {
	public $id = '';
	public $bid = '';
	public $wid = '';
	public $sid = '';
	public $pid = '';
	public $goods_sn = '';
	public $goodsname = '';
	public $goodssubhead = '';
	public $inprice = '';
	public $shopprice = '';
	public $marketprice = '';
	public $leavingcount = '';
	public $salecount = '';
	public $remindcount = '';
	public $storecount = '';
	public $viewcount = '';
	public $commentcount = '';
	public $isonsale = '';
	public $isnew = '';
	public $ishot = '';
	public $ispromotion = '';
	public $autoonsale = '';
	public $unit = '';
	public $recommend = '';
	public $createtime  = '';
	public $onsaletime = '';
	public $edittime = '';
	public $weight = '';
	public $netweight = '';
	public $weightunit = '';
	public $des = '';
	public $keywords = '';
	public $imgcurrent = '';
	public $integral = '';
	public $commentrate='0.00';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

class dropgoods extends models {
	public $id = '';
	public $goodsid = '';
	public $bid = '';
	public $sid = '';
	public $pid = '';
	public $goods_sn = '';
	public $goodsname = '';
	public $inprice = '';
	public $shopprice = '';
	public $marketprice = '';
	public $leavingcount = '';
	public $salecount = '';
	public $remindcount = '';
	public $storecount = '';
	public $viewcount = '';
	public $isonsale = '';
	public $isnew = '';
	public $ishot = '';
	public $ispromotion = '';
	public $autoonsale = '';
	public $unit = '';
	public $recommend = '';
	public $createtime  = '';
	public $onsaletime = '';
	public $edittime = '';
	public $weight = '';
	public $weightunit = '';
	public $des = '';
	public $keywords = '';
	public $description = '';
	public $brand = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}	
}

class goods_ext extends models {
	public $goodsid = '';
	public $description = '';
	public $tagname = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}
//商品和分类的关系
class goodscategory extends models{
	public $id = '';
	public $categoryid = '';
	public $goodsid = '';
	public $isextend = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}
class category extends models{
	
	public $id = '';
	public $categoryname = '';
	public $parentid = '';
	public $level = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//
class attachment extends models {
	public $id = '';
	public $uid = '';
	public $filename = '';
	public $apath = '';
	public $asize = '';
	public $atype = '';
	public $addtime = '';
	public $ayear = '';
	public $amonth = '';
	public $aday = '';
	public $usecount = '';
	public $state = '';
	public $des = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}
class goodsattachment extends models {
	public $id = '';
	public $goodsid = '';
	public $aid = ''; 
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

class goodsrelevancy extends models{
	public $id = '';
	public $parentgoodsid = '';
	public $goodsid = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

class goodsarticle extends models {
	public $id = '';
	public $goodsid = '';
	public $articleid = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

class goodsorder extends models {
	public $id = '';
	public $orderid = '';
	public $goodsid = '';
	public $goodsname = '';
	public $goods_sn = '';
	public $shoppirce = '';
	public $mprice= '';
	public $marketprice = '';
	public $attributeid = '';
	public $attributename = '';
	public $goodscoutn = '';
	public $goods_type = '';
	public $uid='';
	public $cheap = '';
	public $mark = '';
	public $hostgid = '';
	public $freight ='';
	public $ticket = '';

	public static function objects(){
		return new Manager(__CLASS__);
	}
}


class attribute_key extends models{
	public $id = '';
	public $cid = '';
	public $attributetype = '';
	public $attributename = '';
	public $attributevalue = '';
	public $isrelate = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

class attribute_value extends models{
	public $id = '';
	public $aid = '';
	public $goodsid = '';
	public $attributevalue  = '';
	public $attributeprice = '';
	public $relategoods = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//地区
class region extends models{
	public $id = '';
	public $parent_id = '';
	public $region_type = '';
	public $region_name  = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//供货商
class suppliers extends models{
	public $id = '';
	public $suppliername = '';
	public $addr  = '';
	public $con_way  = '';
	public $con_man  = '';
	public $des  = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//生产商
class producer extends models{
	public $id = '';
	public $pname = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//出货单
class salebill extends models{
	public $id = '';
	public $oid = '';
	public $iid = '';
	public $uid = '';
	public $lid = '';
	public $express = '';
	public $billtime = '';
	public $outtime = '';
	public $state = '';
	public $remark = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//品牌
class brand extends models{
	public $id = '';
	public $bname = '';
	public $des = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}


class goods_activity extends models{
	public $id = '';
	public $goods_id = '';
	public $act_id = '';

	public static function objects(){
		return new Manager(__CLASS__);
	}
}

class activity extends models{
	public $id = '';
	public $act_title = '';
	public $act_agio = '';
	public $buy_amount = '';
	public $give_goods = '';
	public $give_amount = '';
	public $money = '';
	public $cheap = '';
	public $integral = '';
	public $start_time = '';
	public $stop_time = '';
	public $act_type = '';
	public $activity_type = '';

	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//积分
class integral extends models{
	public $id = '';
	public $uid = '';
	public $score = '';

	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//会员等级分类
class member extends models{
	public $id = '';
	public $mname = '';
	public $level = '';
	public $ratio = '';
	public $des = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//会员价
class goodsmemberprice extends models{
	public $id = '';
	public $goodsid = '';
	public $mid = '';
	public $mprice = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//物流/快递公司
class logistics extends models{
	public $id = '';
	public $lname = '';
	public $des = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//审核设置
class verify extends models{
	public $id = '';
	public $key = '';
	public $value = '';
	public $des = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//收藏
class collect extends models {
	public $id = '';
	public $uid = '';
	public $gid = '';
	public $remark = '';
	public $collecttime = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//短消息
class shortmessage extends models {
	public $id = '';
	public $fname = '';
	public $tid = '';
	public $title='';
	public $content='';
	public $stime='';
	public $iread='0';
	public $smtype='';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//会员推荐
class commend extends models{
	public $id='';
	public $tid='';
	public $fid='';
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

//收获人信息
class consignee extends models{
	public $id = '';
	public $uid = '';
	public $consigner = '';
	public $country = '';
	public $province = '';
	public $city = '';
	public $county = '';
	public $address = '';
	public $zipcode = '';
	public $phone = '';
	public $tel = '';
	public $email = '';
	public $cons_time = '';
	public $cons_type = '';

	public static function objects(){
		return new Manager(__CLASS__);
	}
}


//品牌
class goodsbrand extends models {
	public $id = '';
	public $gid = '';
	public $bid = ''; 

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//支付记录
class payrecord extends models {
	public $id = '';
	public $uid = '';
	public $ordercode = '';
	public $pay_sn = '';
	public $paynumber = '';
	public $payfee = '';
	public $paytime = '';
	public $paystate = '';

	public static function objects() {
		return new Manager(__CLASS__);
	}
}

//配置信息表
class config extends models{
	public $id = '';
	public $keyword = '';
	public $kvalue = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}
class questioncomment extends models{
	public $id = '';
	public $uid = '';
	public $qid = '';
	public $val = '';
	public $time = '';

     public static function objects(){
		 new Manager(__CLASS__);
	 }
}

//售后服务
class aftersale extends models {
    public $id = '';
    public $oid = '';
    public $uid = '';
    public $type = '';
    public $reason = '';
    public $remark = '';
    public $delivery = '';
    public $express = '';
    public $parcel = '';
    public $address = '';
    public $zipcode = '';
    public $province = '';
    public $city = '';
    public $district = '';
    public $state = '';
    public $time = '';
    public static function objects() {
        return new Manager(__CLASS__);
    }
}
//品牌管理
class tag extends models {
    public $id = '';
    public $bname = '';
    public $bpicpath = '';
    public $des = '';
    public $isindex = '';
    public static function objects() {
        return new Manager(__CLASS__);
    }
}
//作品管理
class works extends models {
	public $id = '';
	public $wname = '';
	public $wpicpath = '';
	public $des = '';
	public $isindex = '';
	
	public static function objects(){
		return new Manager(__CLASS__);
	}
}

?>
