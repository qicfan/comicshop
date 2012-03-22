<?php
class orderFun {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}

	/**
	 * 获取促销方案
	 * @param int $gid 商品id
	 * 2010/05/14 linkorderConsign
	 */
	public static function getPromotion($gid){
		$arry = '';
		try {
			$rel = goods_activity::objects()->filter("goods_id = $gid");
		} catch (Exception $e) {
			$rel = "";
		}
		if($rel){
			foreach ($rel as $item){
				try{
					$result = activity::objects()->get("id = ".$item->act_id." AND ".time().">start_time AND stop_time>".time());
				} catch (Exception $e) {
					$result ='';
				}
				if($result){
					$arry[] = $result;
				}
			}
		}
		return $arry;
	}


	/******************************************************
	 * 修改费用信息
	 ******************************************************/
	public static function updateFee($oid,$cardfee,$tax,$postfee,$packagefee){
		$orders = new orders();
		$orders -> id = $oid;
		$orders -> postfee = $postfee;
		$orders -> packagefee = $packagefee;
		$orders -> tax = $tax;
		$orders -> cardfee = $cardfee;
		$rel = $orders -> save();
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 删除商品所对应的礼品
	 */
	public static function delGoodsGift($goid,$oid){
		global $db;
		$oginfo = orderFun::getOrderGoodsInfo($goid);
		$lar = orderFun::getPromotion($oginfo->goodsid);
		if($lar){
			foreach ($lar as $itm){
				if($itm->activity_type==2){
					try{
						$rel = activity::objects()->get("id = ".$itm->id);
					}catch (Exception $e){
						$rel = '';
					}
					if($rel){
						$buy_amount = $rel->buy_amount;
						$give_amount = $rel->give_amount;
						$give_goods = $rel->give_goods;
						$num = floor($oginfo->goodscoutn/$buy_amount);
						$gcount = $num * $give_amount;
						if($give_goods==0){
							$give_goods=$oginfo->goodsid;
						}
						$sql = "UPDATE goodsorder SET goodscoutn=goodscoutn-".$gcount." WHERE orderid=".$oid." AND goodsid =".$give_goods." AND goods_type=1";
						$re = $db->exec($sql);
						if($re){
							$sql2 = "DELETE FROM goodsorder WHERE orderid=".$oid." AND goodsid=".$give_goods." AND goods_type=1 AND goodscoutn=0";
							$db->exec($sql2);
							return true;
						}
					}
				}
			}
		}
	}

	/**
	 * 购买商品时触发的活动
	 * @param int $oid 订单id
	 */
	public static function setActivity($oid){
		$goinfo = goodsorder::objects()->filter("orderid='$oid' AND goods_type=0");
		foreach($goinfo as $item){
			$typ = orderFun::getGlobalPromotion(2);
			if($typ){
				$largess = orderFun::largess($item->goodsid,$item->goodscoutn,$typ->id,$oid);
			}else{
				$lar = orderFun::getPromotion($item->goodsid);
				if($lar){    //买N送X
					foreach ($lar as $itm){
						if($itm->activity_type==2){
							$largess = orderFun::largess($item->goodsid,$item->goodscoutn,$itm->id,$oid);
						}
					}
				}
			}

			$typ1 = orderFun::getGlobalPromotion(1);
			if($typ1){
				$re_price = orderFun::rebate($item->shoppirce,$item->goodscoutn,$typ1->id);
				$gorder = new goodsorder();
				$gorder ->id = $item->id;
				$gorder ->act_price = $re_price;
				$gorder ->save();
			}else{
				$lar = orderFun::getPromotion($item->goodsid);
				if($lar){    //折扣
					foreach ($lar as $itm){
						if($itm->activity_type==1){
							$re_price = orderFun::rebate($item->shoppirce,$item->goodscoutn,$itm->id);
							$gorder = new goodsorder();
							$gorder ->id = $item->id;
							$gorder ->act_price = $re_price;
							$gorder ->save();
						}
					}
				}
			}
		}
		$amount = orderFun::getGoodsOrderMoney($oid);
		$order = new orders();
		$order -> id = $oid;
		$order -> goodsmount = $amount;
		$or = $order -> save();
	}

	/**
	 * 获取全场促销活动
	 * @param int $typ 活动类型
	 */
	public static function getGlobalPromotion($typ){
		try{
			$rel = activity::objects()->get("act_type = 1 AND ".time().">start_time AND ".time()."<stop_time AND activity_type = '$typ'");
		}catch (Exception $e) {
			$rel = '';
		}
		return $rel;
	}

	/**
	 * 送积分
	 * @param int $uid 用户id
	 * @param int $expenditure 消费金额
	 * @param int $act_id 活动id
	 * 2010/05/17 link
	 */
	public static function integral($uid,$expenditure,$act_id){
		try{
			$rel = activity::objects()->get("id = '$act_id'");
		}catch (Exception $e) {
			$rel = '';
		}
		if($rel){
			$money = $rel -> money;
			$integ = $rel -> integral;
			$num = floor($expenditure/$money);
			$integral = $integ*$num;
			try{
				$resu = integral::objects()->get("uid ='$uid'");	
			} catch (Exception $e) {
				$resu = false;
			}
			if($resu){
				$intral = new integral();
				$intral -> id = $resu->id;
				$intral ->score = ($integral+$resu->score);
				$result = $intral ->save();
			}else{
				$intral = new integral();
				$intral ->uid = $uid;
				$intral ->score = $integral;
				$result = $intral ->save();
			}
			if($result){
				return true;
			}else{
				return false;
			}
		}
	}

	/**********************************************************
	 * 赠送积分
	 * @param int $uid 用户id
	 * @param int $inte 积分
	 **********************************************************/
	public static function setIntegral($uid,$inte){
		$ch = orderFun::checkInteUser($uid);
		if($ch){
			$score= $ch->score;
			$id = $ch->id;
			$intral = new integral();
			$intral ->id = $id;
			$intral ->score = $score + $inte;
			$rel = $intral ->save();
		}else{
			$sco = new integral();
			$sco ->uid = $uid;
			$sco ->score = $inte;
			$rel = $sco ->save();
		}
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/**********************************************************
	 * 判断积分表中是否存在此用户
	 **********************************************************/
	public static function checkInteUser($uid){
		try{
			return integral::objects()->get("uid ='$uid'");
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * 打折(N件以上打m折)
	 * @param int $shopprice 原价
	 * @param int $count 购买数量
	 * @return int cheap 优惠价
	 * 2010/05/17 link
	 */
	public static function rebate($shopprice,$count,$act_id){
		$price = $shopprice;
		try{
			$rel = activity::objects()->get("id = ".$act_id);
		}catch (Exception $e) {
			$rel = '';
		}
		if($rel){
			if($count>=$rel->buy_amount){
				$agio = $rel->act_agio;
			}else{
				$agio = 10;
			}
			$price = $shopprice * ($agio*10/100);
		}
		return $price;
	}

	/**
	 * 送优惠券
	 * @param int $uid 用户id
	 * @param int $subtotal 小计
	 * @param int $act_id 活动id
	 * @param int $stoptime 结束时间
	 * link
	 */
	public static function cheap($uid,$subtotal,$act_id,$stoptime){
		try{
			$rel = activity::objects()->get("id = $act_id");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			$money = $rel -> money;
			$cheap = $rel -> cheap;
			$multiple = floor($subtotal/$money);
			$brow = $cheap * $multiple;
			$code = orderFun::cheapCode($brow);
			$fee = $brow;
			$starttime = time();
			$deadline = $stoptime;
			$state = 1;
			//优惠券信息写入数据库已封装
			require_once PRO_ROOT . 'include/other.class.php';
			$rel = other::addCoupon($code, $fee, $starttime, $deadline, $state, $uid);
			if($rel){
				return true;
			}else{
				return false;
			}
		}
	}


	/**************************************************
	 * 赠送优惠券
	 * @param int $fee 券额
	 * @param int $uid 用户id
	 **************************************************/
	public static function coupon($fee,$uid){
		$code = orderFun::cheapCode($brow);
		$starttime = time();
		$deadline = time()+COUPON*3600*24;
		$rel = other::addCoupon($code, $fee, $starttime, $deadline, 1, $uid);
		if($rel){
			return true;
		}else{
			return false;
		}
	}


	/**
	 * 买N送x
	 * @param int $gid 商品id
	 * @param int $count 购买数量
	 * @param int $act_id 促销id
	 * @param int $oid 订单id
	 * link
	 */
	public static function largess($gid,$count,$act_id,$oid){
		global $db;
		try{
			$rel = activity::objects()->get("id = $act_id");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			$buy_amount = $rel->buy_amount;
			$give_amount = $rel->give_amount;
			$give_goods = $rel->give_goods;
			$num = floor($count/$buy_amount);
			$gcount = $num * $give_amount;

			if($gcount>=0){
				if($give_goods==0){
					$goods = Ware::GetOne($gid);
					$gattribute = Ware::getGoodsAttribute($gid);
				}else{
					$goods = Ware::GetOne($give_goods);
					$gattribute = Ware::getGoodsAttribute($give_goods);
				}
				$attrname = '';
				$accrid = '';
				foreach ($gattribute as $item){
					$attrname.=$item['attributevalue'].' ';
					$accrid.=$item['id'].',';
				}
				try{
					$grel = goodsorder::objects()->get("orderid = '$oid' AND goodsid =".$goods->id." AND goods_type =1");    //判断订单中是否有此商品
				}catch (Exception $e){
					$grel ='';
				}
				if($grel){
					if($gcount==0){
						$desql = "DELETE FROM goodsorder WHERE id=".$grel->id;
						$del = $db->exec($desql);
						if($del){
							return true;
						}
					}
					if($gcount!=0){
						$sqls = "UPDATE goodsorder SET goodscoutn=".$gcount." WHERE id=".$grel->id;
						$gr = $db->exec($sqls);
						if($gr){
							return true;
						}
					}
				}else{
					if($gcount!=0){
						$gorder = new goodsorder();
						$gorder -> orderid = $oid;
						$gorder -> goodsid = $goods->id;
						$gorder -> goodsname = $goods->goodsname;
						$gorder -> goods_sn = $goods->goods_sn;
						$gorder -> shoppirce = $goods->shopprice;
						$gorder -> act_price = $goods->shopprice;
						$gorder -> marketprice = $goods->marketprice;
						$gorder -> attributeid = substr($accrid,0,$accrid.length-1);
						$gorder -> attributename = substr($attrname,0,$attrname.length-1);
						$gorder -> goodscoutn = $gcount;
						$gorder -> goods_type =1;
						$rel = $gorder -> save();
						if($rel){
							return true;
						}
					}
				}
			}
		}
	}

	/**
	 * 订单编号
	 * @param int $uid 用户id
	 * link
	 */
	public static function orderCode($uid){
		$user = '';
		if($uid==0){
			$user = 'N';
			for($i=0;$i<8;$i++){
				$user.=rand(0,9);
			}
		}else{
			$len = strlen($uid);
			if((9-$len)>=0){
				$nul = '';
				for($l=0;$l<(9-$len);$l++){
					$nul.='0';
				}
				$user = $nul.$uid;
			}else{
				$u='L';
				for($j=0;$j<8;$j++){
					$u.=rand(0,9);
				}
				$user = $u;
			}
		}
		$code = 'CM'.date('YmdHis',time()).$user;
		return $code;
	}

	/**
	 * 优惠券编号
	 * @param int $brow 额度
	 * link
	 */
	public static function cheapCode($brow){
		$random = '';
		for($i=0;$i<4;$i++){
			$random.=rand(0,9);
		}
		$code = 'CM'.$brow.'-'.date('YmdHis').'-'.$random;
		try{
			$rel = coupon::objects()->get("code = '$code'");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			orderFun::cheapcode($brow);
		}else{
			return $code;
		}
	}

	/**
	 * 满N免运费
	 * @param int $brow 额度
	 * @param int act_id 活动id
	 * link
	 */
	public static function conveyFee($brow,$act_id){
		try{
			$rel = activity::objects()->get("id = $act_id");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			$money = $rel->money;
			if($brow>=$money){
				return true;
			}else{
				return false;
			}
		}
	}

	/**
	 * 获取订单信息根据订单状态
	 * @param int $state 订单状态 0无效（新的）1有效；2取消；3成功
	 * link
	 */
	public static function getOrderByState($state){
		try{
			$rel = orders::objects()->filter("orderstate = '$state'");
		}catch (Exception $e){
			$rel = '';
		}
		return $rel;
	}

	/**
	 * 获取订单信息根据支付状态
	 * @param int $paystate 支付状态 0未支付；1已支付
	 * link
	 */
	public static function getOrderByPaystate($paystate){
		try{
			$rel = orders::objects()->filter("paystate = '$paystate'");
		}catch (Exception $e){
			$rel = '';
		}
		return $rel;
	}

	/**
	 * 获取订单信息根据配送方式
	 * @param int $poststate 配送方式 0未发货，1配货中 2已发货
	 * link
	 */
	public static function getOrderByPoststate($poststate){
		try{
			$rel = orders::objects()->filter("poststate = '$poststate'");
		}catch (Exception $e){
			$rel = '';
		}
		return $rel;
	}

	
	/**
	 * 获取订单数量
	 * @param string $state 订单状态:new新订单，nopayment未付款
	 * payment已付款；nocarry未发货；carry配货中；carryed已发货
	 * link
	 */
	public static function getOrderCount($state){
		switch ($state){
			case 'new':
				$rel = orderFun::getOrderByState(0);
				break;
			case 'nopayment':
				$rel = orderFun::getOrderByPaystate(0);
				break;
			case 'payment':
				$rel = orderFun::getOrderByPaystate(1);
				break;
			case 'nocarry':
				$rel = orderFun::getOrderByPoststate(0);
				break;
			case 'carry':
				$rel = orderFun::getOrderByPoststate(1);
				break;
			case 'carryed':
				$rel = orderFun::getOrderByPoststate(2);
				break;
		}
		return count($rel);
	}

	/********************************************************
	 * 修改订单状态
	 * @param int $oid 订单id
	 * @param int $state 订单状态 0无效；1有效；2取消；3成功
	 * link
	 ********************************************************/
	public static function updateOrderState($oid,$state){
		$order = new orders();
		$order -> id = $oid;
		if($state==1){
			$order -> confirmtiem = time();
		}
		if($state==3){
			$order -> accepttime = time();
		}
		$order -> orderstate = $state;
		$rel = $order -> save();
		if($rel){
			return true;
		}else{
			return false;
		}
	}
	

	/*******************************************************
	 * 修改配货状态
	 * @param int $oid 订单id
	 * @param int $state 状态  0未发货；1配货中即生成发货单；2发货
	 * link
	 *******************************************************/
	public static function updateOrderPoststate($oid,$state){
		$order = new orders();
		$order -> id = $oid;
		if($state==2){
			$order -> posttime = time();
		}
		$order -> poststate = $state;
		$rel = $order -> save();
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/*******************************************************
	 * 修改支付状态
	 * @param int $oid 订单id
	 * @param int $state 状态 0未付款，1已付款
	 * @param int $tim 支付时间
	 * link
	 *******************************************************/
	public static function updateOrderPaystate($oid,$state,$tim=''){
		$order = new orders();
		$order -> id = $oid;
		if($state==1){
			if($tim==''){
				$order -> paytime = time();
			}else{
				$order -> paytime = $tim;
			}
		}
		$order -> paystate = $state;
		$rel = $order -> save();
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 查看订单中是否存在某商品
	 * @param int $oid 订单id
	 * @param int $gid 商品id
	 * @return true/false
	 */
	public static function checkOrderGoods($oid,$gid){
		try{
			$rel = goodsorder::objects()->filter("orderid = '$oid' AND goodsid = '$gid'");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/**********************************************
	 * 根据订单编号获取订单id
	 **********************************************/
	public static function getOidByOrderSn($order_sn){
		try{
			$rel = orders::objects()->get("order_sn='$order_sn'");
		}catch (Exception $e){
			$rel ='';
		}
		if($rel){
			return $rel->id;
		}
	}

	/**
	 * 获取订单总额（获取订单商品表中商品的总额）
	 */
	public static function getGoodsOrderMoney($oid){
		$amount = 0;
		try{
			$rel = goodsorder::objects()->filter("orderid = '$oid' AND goods_type = 0");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			foreach ($rel as $item){
				$amount+=($item->act_price*$item->goodscoutn);
			}
		}
		return $amount;
	}

	/**
	 * 判断商品数量是否能够买
	 * @param int $gid 商品id
	 * @param int $count 购买数量
	 * @return bol true/false
	 */
	public static function checkGoodsCount($gid,$count){
		try{
			$rel = goods::objects()->get("id = '$gid'");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			if($count>$rel->leavingcount){
				return false;
			}else{
				return true;
			}
		}
	}

	/**
	 * 判断商品是否为上架商品
	 * @param int $gid 商品id
	 * @return bol true/false
	 */
	public static function checkGoodsIsonsale($gid){
		try{
			$rel = goods::objects()->get("id = '$gid'");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			if($rel->isonsale==1 || $rel->isonsale ==2){
				return true;
			}else{
				return false;
			}
		}
	}

	/***************************************************
	 * 获取订单详情
	 * @param int $oid 订单id
	 ***************************************************/
	public static function getOrderInfo($oid){
		try{
			$rel = orders::objects()->get("id = '$oid'");
		}catch (Exception $e){
			$rel = '';
		}
		return $rel;
	}

	/*************************************************
	 * 订单发货数量减少
	 * @param int $oid 订单id
	 *************************************************/
	public static function upAmount($oid){
		global $db;
		try{
			$goo = goodsorder::objects()->filter("orderid = '$oid'");
		}catch (Exception $e){
			$goo ='';
		}
		if($goo){
			$i=0;
			foreach ($goo as $item){
				$gid = $item->goodsid;
				$gcount = $item ->goodscoutn;
				$rel = goods::objects()->get("id = '$gid'");
				if($gcount>$rel->leavingcount){
					$i++;
				}
			}
			if($i==0){
				foreach ($goo as $item){
					$gid = $item->goodsid;
					$gcount = $item ->goodscoutn;
					$sql = "UPDATE goods SET leavingcount=leavingcount-".$gcount." WHERE id='$gid'";		
					$db->exec($sql);
				}
			}
		}
	}

	/**
	 * 根据订单商品id获取相应信息
	 * @param int $goid 订单对应的商品id
	 */
	public static function getOrderGoodsInfo($goid){
		try{
			$oginfo = goodsorder::objects()->get("id = '$goid'");
		}catch (Exception $e){
			$oginfo ='';
		}
		return $oginfo;
	}



	/************************************************
	 * 还原商品数量
	 * @param string $ordercode 订单编号
	 ************************************************/
	public static function revertGoodsCount($ordercode){
		require_once PRO_ROOT . 'include/goods.class.php';
		$oid = self::getOidByOrderSn($ordercode);
		$ginfo = goodsorder::objects()->filter("orderid='$oid'");
		foreach ($ginfo as $itm){
			$ginfo = Ware::GetOne($itm->goodsid);
			if($ginfo){
				$goods = new goods();
				$goods ->id = $itm->goodsid;
				$goods ->leavingcount =$ginfo->leavingcount + $itm->goodscoutn;
				$goods ->salecount =$ginfo->salecount - $itm->goodscoutn;
				$goods ->save();
			}
		}
	}


	/************************************************
	 * 退款成功更改订单状态
	 * @param string $ordercode 订单
	 ************************************************/
	public static function updateOrderStateByOrcode($ordercode){
		$oid = self::getOidByOrderSn($ordercode);
		$order = new orders();
		$order -> id = $oid;
		$order -> orderstate = 4;
		$order -> paystate =2;
		$rel = $order -> save();
		if($rel){
			return true;
		}else{
			return false;
		}
	}
	


	/****************************************** 前台 ************************************************/
	/**
	 * 收获人信息
	 * @param int $uid 用户id
	 */
	public static function getConsign($uid,$ty){
		try{
			$rel = consignee::objects()->filter("uid='$uid' AND cons_type='$ty'");
			if($rel){
				return $rel;
			}
		}catch (Exception $e){
			return '';
		}
	}

	/**
	 * 添加收货人信息
	 */
	public static function addConsign($uid,$consigner,$addr,$zip,$tel,$phone,$email,$s1,$s2,$s3){
		$cons = new consignee();
		$cons ->uid = $uid;
		$cons ->consigner = $consigner;
		$cons ->country = 0;
		$cons ->province = $s1;
		$cons ->city = $s2;
		$cons ->county = $s3;
		$cons ->address = $addr;
		$cons ->zipcode = $zip;
		$cons ->phone = $phone;
		$cons ->tel = $tel;
		$cons ->email = $email;
		$cons ->cons_time = time();
		$cons ->cons_type = 0;
		$rel = $cons ->save();
		if($rel){
			$conid = base::getInsertId();
			return $conid;
		}else{
			return false;
		}
	}

	/**
	 * 保存最近的收货地址
	 */
	public static function saveConsign($uid,$consigner,$addr,$zip,$tel,$phone,$email,$s1,$s2,$s3){
		$rel = orderFun::getConsign($uid,1);
		if($rel){
			$cons = new consignee();
			$cons -> id = $rel[0] -> id;
			$cons -> uid = $uid;
			$cons -> consigner = $consigner;
			$cons -> address = $addr;
			$cons -> zipcode = $zip;
			$cons -> phone = $phone;
			$cons -> tel = $tel;
			$cons -> email = $email;
			$cons -> province = $s1;
			$cons -> city = $s2;
			$cons -> county = $s3;
			$cons -> cons_time = time();
			$result = $cons -> save();
			if($result){
				return $rel[0]->id;
			}else{
				return false;
			}
		}else{
			$cons = new consignee();
			$cons -> uid = $uid;
			$cons -> consigner = $consigner;
			$cons -> address = $addr;
			$cons -> zipcode = $zip;
			$cons -> phone = $phone;
			$cons -> tel = $tel;
			$cons -> email = $email;
			$cons -> province = $s1;
			$cons -> city = $s2;
			$cons -> county = $s3;
			$cons -> cons_type = 1;
			$cons -> cons_time = time();
			$sav = $cons -> save();
			if($sav){
				$saveid = base::getInsertId();
				return $saveid;
			}
		}
	}

	/**
	 * 删除用户收货地址
	 */
	public static function delConsign($consid){
		$cons = new consignee();
		$cons -> id = $consid;
		$rel = $cons -> delete();
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/*************************************************
	 * 生成订单
	 *************************************************/
	public static function makeOrder($orcode,$uid){
		if($uid == 0){
			if(isset($_COOKIE['orpart'])){
				$or = $_COOKIE['orpart']; 
			}else{
				$ip = base::GetIp();
				$ipd = str_replace('.',"",$ip);
				$date = date('YmdHis',time());
				$or = $ipd.$date;
				setcookie('orpart',$or);
			}
		}
		$order = new orders();
		$order -> order_sn = $orcode;
		$order -> uid = $uid;
		$order -> orpart = $or;
		$order -> createtime = time();
		$order -> operator =2;
		$rel = $order -> save();
		if($rel){
			$orderid = base::getInsertId();
			return $orderid;
		}else{
			return false;
		}
	}

	/*****************************************
	 * 添加订单信息
	 *****************************************/
	public static function orderConsign($oid,$consigner,$tel,$addr,$zip,$phone,$email,$prov,$city,$dist,$payty,$paytyp,$ztaddr,$yunfee,$zttime,$fpty,$tptt,$fpcontent,$remark,$tickid,$tickmoney,$besttime){
		$order = new orders();
		$order -> id = $oid;
		$order -> consignee = $consigner;
		$order -> country =0;
		$order -> province = $prov;
		$order -> city = $city;
		$order -> district = $dist;
		$order -> address = $addr;
		$order -> zipcode = $zip;
		$order -> tel = $phone;
		$order -> mobile = $tel;
		$order -> email = $email;
		$order -> posttype = $payty;
		$order -> paytype = $paytyp;
		$order -> ztaddr = $ztaddr;
		$order -> postfee = $yunfee;
		$order -> zttime = $zttime;
		$order -> invoicetype = $fpty;
		$order -> invoicehead = $fptt;
		$order -> invoicecontent = $fpcontent;
		$order -> cardid = $tickid;
		$order -> remark = $remark;
		$order -> besttime = $besttime;
		$order -> cardfee = $tickmoney;
		$rel = $order -> save();
		if($rel){
			return true;
		}
	}

	/******************************************************
	 * 检查购物车中的商品数量是否可购买
	 ******************************************************/
	public static function checkCartGoodsCount($uid,$cartcode){
		require_once PRO_ROOT . 'include/goods.class.php';
		$cart = cartFun::getCart($uid,$cartcode);
		$aut = 0;
		$stock = array();
		if($cart){
			foreach ($cart as $item){
				$ginfo = Ware::GetOne($item -> goodsid);
				if($ginfo->leavingcount < $item -> goodscount){
					$stock[]=array('gid'=>$item -> goodsid,'gname'=>$ginfo->goodsname,'leavingcount'=>$ginfo->leavingcount);
					$aut++;
				}
			}
		}
		if($aut == 0){
			return 1;
		}else{
			return $stock;
		}
	}


	/******************************************************
	 * 添加订单商品 
	 ******************************************************/
	public static function makeOrGoods($oid,$uid,$cartcode){
		if($uid==0){
			$cart = cartFun::getCart(0,$cartcode);
			if($cart){
				foreach ($cart as $item){
					$org = new goodsorder();
					$org -> orderid = $oid;
					$org -> goodsid = $item -> goodsid;
					$org -> goodsname = $item -> goodsname;
					$org -> goods_sn = $item -> goods_sn;
					$org -> shoppirce = $item ->shoppirce;
					$org -> mprice = $item -> mprice;
					$org -> marketprice = $item -> marketprice;
					$org -> attributeid = $item -> attributeid;
					$org -> attributename = $item -> attributename;
					$org -> goodscoutn = $item -> goodscount;
					$org -> goods_type = $item -> largess;
					$org -> uid = 0;
					$org -> cheap = $item -> cheap;
					$org -> mark = $item -> mark;
					$org -> hostgid = $item -> host;
					$org -> freight = $item ->freight;
					$org -> ticket = $item -> ticket;
					$rel = $org -> save();
					if($rel){
						$car = new cart();
						$car -> id = $item->id;
						$car -> delete();
					}
				}
			}
		}else{
			$cart = cartFun::getCart($uid,'');
			if($cart){
				foreach ($cart as $item){
					$org = new goodsorder();
					$org -> orderid = $oid;
					$org -> goodsid = $item -> goodsid;
					$org -> goodsname = $item -> goodsname;
					$org -> goods_sn = $item -> goods_sn;
					$org -> shoppirce = $item ->shoppirce;
					$org -> mprice = $item -> mprice;
					$org -> marketprice = $item -> marketprice;
					$org -> attributeid = $item -> attributeid;
					$org -> attributename = $item -> attributename;
					$org -> goodscoutn = $item -> goodscount;
					$org -> goods_type = $item -> largess;
					$org -> uid = $uid;
					$org -> cheap = $item -> cheap;
					$org -> mark = $item -> mark;
					$org -> hostgid = $item -> host;
					$org -> freight = $item ->freight;
					$org -> ticket = $item -> ticket;
					$rel = $org -> save();
					if($rel){
						$car = new cart();
						$car -> id = $item->id;
						$car -> delete();
					}
				}
			}
		}
		$gamount = orderFun::getOrderMoney($oid);
		$order = new orders();
		$order -> id = $oid;
		$order -> goodsmount = $gamount;
		$order -> save();
	}

	/*********************************************
	 * 获取订单总额
	 *********************************************/
	public static function getOrderMoney($oid){
		$amount = 0;
		try{
			$rel = goodsorder::objects()->filter("orderid = '$oid' AND goods_type = 0");
			$orinfo = orders::objects()->get("id='$oid'");
		}catch (Exception $e){
			$rel = '';
		}
		if($rel){
			foreach ($rel as $item){
				$amount+=($item->mprice*$item->goodscoutn - $item->cheap);
			}
		}
		if($orinfo->freight==0){
			$amount+=postfee;
		}
		$amount+=packagefee+tax-cardfee;
		return $amount;
	}

	/**
	 * 获取我的订单
	 */
	public static function getMyOrder($uid){
		if($uid==0){
			if(isset($_COOKIE['orpart'])){
				$orpart = $_COOKIE['orpart'];
				$orp = orders::objects()->filter("uid=0 AND orpart ='$orpart'");
				if($orp){
					return $orp;
				}
			}
		}else{
			$orp = orders::objects()->filter("uid = '$uid'");
			if($orp){
				return $orp;
			}
		}
	}

	/***********************************************
	 * 修改订单商品的数量  ----order
	 ***********************************************/
	public static function changeOrGoodsCount($gorid,$count,$oid,$gid){
		global $db;
		require_once PRO_ROOT . 'include/goods.class.php';
		require_once PRO_ROOT . 'include/cheapFun.class.php';
		$rel = Ware::GetOne($gid);
		$or = orders::objects()->get("id='$oid'");
		$uid = $or->uid;

		if($rel->leavingcount>=$count){    //判断商品的剩余数量
			cheapFun::clearGorderlargess($oid,$gid);    //清空购物车中此商品的赠品
			if($rel){
				if($uid != 0){
					$mid = cheapFun::getUserMid($uid);
					if($mid){
						$price = cheapFun::getGoodsMemberPrice($gid,$mid);
					}else{
						$price = $rel->shopprice;
					}
				}else{
					$price = $rel->shopprice;
				}
				$act = cheapFun::getPromotion($gid);    //获取商品活动
				foreach ($act as $item){
					$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
					if($gcheap){
						$cheap = cheapFun::rebate($price,$count,$gcheap->id);    //获取优惠金额
					}else{
						if($item->activity_type==1){
							$cheap = cheapFun::rebate($price,$count,$item->id);    //获取优惠金额
						}
					}
				
						
					$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
					if($largess){
						cheapFun::orlargess($gid,$count,$largess->id,$oid,$uid);
					}else{
						if($item ->activity_type==2){    //赠品活动
							cheapFun::orlargess($gid,$count,$item->id,$oid,$uid);
						}
					}
										
					$mark = cheapFun::getGlobalPromotion(3);    //获取全局的积分活动
					$money = $price*$count;    //消费金额
					if($mark){
						$mar = cheapFun::mark($money,$mark->id);    //获取积分
					}else{
						if($item->activity_type==3){
							$mar = cheapFun::mark($money,$item->id);    //获取积分
						}
					}

					
					$ticket = cheapFun::getGlobalPromotion(4);    //获取全局的优惠券金额
					$money = $price*$count;    //消费金额
					if($ticket){
						$tick = cheapFun::cheap($uid,$money,$ticket->id);
					}else{
						if($item->activity_type==4){
							$tick = cheapFun::cheap($uid,$money,$item->id);
						}
					}

					
					$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
					$money = $price*1;    //消费金额
					if($fee){
						$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
					}else{
						if($item->activity_type==5){
							$yf = cheapFun::conveyFee($money,$item->id);
						}
					}
					if($yf){
						$yf = 1;
					}else{
						$yf = 0;
					}
				}
			}
		
			$gr = new goodsorder();
			$gr ->id = $gorid;
			$gr ->goodscoutn = $count;
			$gr ->mark = $mar;
			$gr ->cheap = $cheap;
			$gr ->freight = $yf;
			$gr ->ticket = $tick;
			$rel = $gr ->save();
			if($rel){
				return 1;
			}else{
				return 2;
			}
		}
	}

	/************************************************
	 * 删除订单中的商品
	 ************************************************/
	public static function delOrGoods($gorid,$gid){
		global $db;
		$gorder = new goodsorder();
		$gorder -> id = $gorid;
		$rel = $gorder -> delete();
		if($rel){
			$sql = "DELETE FORM goodsorder WHERE hostgid = '$gid'";
			$db ->exec($sql);
			return true;
		}else{
			return false;
		}
	}


	/************************************************
	 * 更新订单的费用信息
	 ************************************************/
	public static function updateOrFee($oid){
		$rel = goodsorder::objects()->filter("orderid = '$oid'");
		$money = 0;
		$mark = 0;
		$cheap = 0;
		$freight = 0;
		$ticket = 0;
		foreach ($rel as $item){
			if($item ->goods_type ==0){
				$money = $money + $item ->shoppirce * $item ->goodscoutn;
				$mark = $mark + $item -> mark;
				$cheap = $cheap + $item ->cheap;
				$freight = $freight + $item ->freight;
				$ticket = $ticket + $item ->ticket;
			}
		}
		$ord = new orders();
		$ord -> id = $oid;
		$ord ->	goodsmount = $money;
		$ord -> integral = $mark;
		if($freight !=0){
			$ord -> freight =1;
		}
		$ord -> ticket = $ticket;
		$ord -> cheap = $cheap;
		$re = $ord -> save();
		if($re){
			return true;
		}else{
			return false;
		}
	}




	
	/**
	 * 取得订单状态的名称
	 */
	public static function getOrderstateName( $state ) {
		switch($state) {
			case 0:
				return '审核中';
				break;
			case 1:
				return '有效';
				break;
			case 2:
				return '已取消';
				break;
			case 3:
				return '已完成';
				break;
		}
	}
	
	/**
	 * 取得订单支付状态的名称
	 */
	public static function getPaystateName( $state ) {
		switch($state) {
			case 0:
				return '未支付';
				break;
			case 1:
				return '已支付';
				break;
		}
	}	
	
	/**
	 * 取得订单送货状态的名称
	 */
	public static function getPoststateName( $state ) {
		switch($state) {
			case 0:
				return '未发货';
				break;
			case 1:
				return '配货中';
				break;
			case 2:
				return '已发货';
				break;
		}
	}
	
	/**
	 * 取得订单最佳送货时间的名称
	 */
	public static function getBesttimeName( $state ) {
		switch($state) {
			case 1:
				return '随时';
				break;
			case 2:
				return '周一到周五';
				break;
			case 3:
				return '周末';
				break;
		}
	} 
	
	/**
	 * 取得订单付款方式的名称
	 */
	public static function getPaytypeName( $state ) {
		switch($state) {
			case 0:
				return '网上支付';
				break;
			case 1:
				return '货到付款';
				break;
		}
	}
	
	/**
	 * 取得订单送货方式的名称
	 */
	public static function getPosttypeName( $state ) {
		switch($state) {
			case 0:
				return '自提';
				break;
			case 1:
				return '快递';
				break;
			case 2:
				return 'EMS';
				break;
		}
	}
	 
}
?>