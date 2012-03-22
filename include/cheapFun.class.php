<?php
class cheapFun{
	/**
	 * 获取促销方案
	 * @param int $gid 商品id
	 * 2010/05/14 link
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
					$result =array();
				}
				if($result){
					$arry[] = $result;
				}
			}
		}
		return $arry;
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
	 * 折扣优惠
	 * @param int $shopprice 原价
	 * @param int $count 购买数量
	 * @actid int $act_id 活动id
	 * @return int $cheap 优惠额
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
		$cheap =($shopprice*$count)-($price*$count);
		return $cheap;
	}

	/**
	 * 积分
	 */
	public static function mark($expenditure,$act_id){
		$integral = 0;
		try{
			$rel = activity::objects()->get("id = '$act_id'");
			if($rel){
				$money = $rel -> money;
				$integ = $rel -> integral;
				$num = floor($expenditure/$money);
				$integral = $integ*$num;
			}
		}catch (Exception $e) {
			$integral = 0;
		}
		return $integral;
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
	
	/********************************************
	 * 购物车中的赠品
	 ********************************************/
	public static function largess($gid,$count,$act_id,$uid,$cartnumber){
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
			if($gcount >0){
				if($give_goods==0){
					$goods = Ware::GetOne($gid);
					$cart = new cart();
					$cart ->cartnumber = $cartnumber;
					$cart ->uid = $uid;
					$cart ->goodsid = $gid;
					$cart ->goods_sn = $goods->goods_sn;
					$cart ->goodsname = $goods->goodsname;
					$cart ->shoppirce = $goods->shopprice;
					$cart ->marketprice = $goods->marketprice;
					$cart ->goodscount = $gcount;
					$cart ->carttime = time();
					$cart ->largess = 1;
					$cart ->host = $gid;
					$cart ->save();
				}else{
					$goods = Ware::GetOne($give_goods);
					$cart = new cart();
					$cart ->cartnumber = $cartnumber;
					$cart ->uid = $uid;
					$cart ->goodsid = $give_goods;
					$cart ->goods_sn = $goods->goods_sn;
					$cart ->goodsname = $goods->goodsname;
					$cart ->shoppirce = $goods->shopprice;
					$cart ->marketprice = $goods->marketprice;
					$cart ->goodscount = $gcount;
					$cart ->carttime = time();
					$cart ->largess = 1;
					$cart ->host = $gid;
					$cart ->save();
				}
			}
		}
	}
	
	/*************************************************************
	 * 订单商品数量修改  -- 赠品
	 *************************************************************/
	public static function orlargess($gid,$count,$act_id,$oid,$uid){
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
			if($gcount >0){
				if($give_goods==0){
					$goods = Ware::GetOne($gid);
					$gr = new goodsorder();
					$gr ->orderid = $oid;
					$gr ->goodsid = $gid;
					$gr ->goods_sn = $goods->goods_sn;
					$gr ->goodsname = $goods->goodsname;
					$gr ->shoppirce = $goods->shopprice;
					$gr ->act_price = $goods->shopprice;
					$gr ->marketprice = $goods->marketprice;
					$gr ->goodscoutn = 1;
					$gr ->goods_type = 1;
					$gr ->uid = $uid;
					$gr ->hostgid = $gid;
					$gr ->save();
				}else{
					$goods = Ware::GetOne($give_goods);
					$gr = new goodsorder();
					$gr ->orderid = $oid;
					$gr ->goodsid = $give_goods;
					$gr ->goods_sn = $goods->goods_sn;
					$gr ->goodsname = $goods->goodsname;
					$gr ->shoppirce = $goods->shopprice;
					$gr ->act_price = $goods->shopprice;
					$gr ->marketprice = $goods->marketprice;
					$gr ->goodscoutn = 1;
					$gr ->goods_type = 1;
					$gr ->uid = $uid;
					$gr ->hostgid = $gid;
					$gr ->save();
				}
			}
		}
	}

	/***************************************************
	 * 当修改购物车商品数量时清空购物车商品的赠品
	 * @param int $gid 商品id
	 * @param int $uid 用户id
	 * @param string $cartcode 购物车编号
	 ***************************************************/
	public static function uplargess($gid,$uid,$cartcode){
		$cart = new cart();
		$cart -> host = $gid;
		$cart -> cartnumber = $cartcode;
		$cart -> uid =$uid;
		$cart -> largess = 1;
		$cart ->delete();
	}

	/***************************************************
	 * 修改订单商品数量时 清空订单商品中的赠品
	 * @param int $oid 订单id
	 * @param int $gid 商品id
	 ***************************************************/
	public static function clearGorderlargess($oid,$gid){
		$gor = new goodsorder();
		$gor -> orderid = $oid;
		$gor -> hostgid = $gid;
		$gor -> goods_type = 1;
		$gor ->delete();
	}

	/**
	 * 送优惠券
	 * @param int $uid 用户id
	 * @param int $subtotal 小计
	 * @param int $act_id 活动id
	 * link
	 */
	public static function cheap($uid,$subtotal,$act_id){
		try{
			$rel = activity::objects()->get("id = $act_id");
			if($rel){
				$money = $rel -> money;
				$cheap = $rel -> cheap;
				$multiple = floor($subtotal/$money);
				$brow = $cheap * $multiple;
			}
		}catch (Exception $e){
			$rel = '';
		}
		return $blow;
	}

	/***********************************************
	 * 查询用户优惠券
	 ***********************************************/
	public static function getUserTicket($uid){
		try{
			$rel = coupon::objects()->filter("uid = '$uid' AND ".time()."<=deadline ORDER BY fee");
		}catch(Exception $e){
			$rel ='';
		}
		return $rel;
	}

	/***********************************************
	 * 获取商品的会员价
	 * @param int $gid 商品id
	 * @param int $mid 会员等级id
	 ***********************************************/
	public static function getGoodsMemberPrice($gid,$mid){
		try{
			$rel = goodsmemberprice::objects()->get("goodsid='$gid' AND mid = '$mid'");
		}catch(Exception $e){
			$rel = '';
		}
		if($rel){
			return $rel->mprice;
		}
	}

	/************************************************
	 * 获取用户会员等级id
	 * @param int $uid 用户id
	 ************************************************/
	public static function getUserMid($uid){
		try{
			$rel = user::objects()->get("uid='$uid'");
		}catch(Exception $e){
			$rel = '';
		}
		if($rel){
			return $rel->member;
		}
	}
}
?>