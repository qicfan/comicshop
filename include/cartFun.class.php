<?php
class cartFun{
	private function __construct() {
	}

	/*******************************************
	 * 生成购物车编号
	 * 时间+随机数
	 *******************************************/
	public static function getCartNumber(){
		$tim = date('YmdHis',time());
		$ran='';
		for($i=0;$i<6;$i++){
			$ran.=rand(0,9);
		}
		return $tim.$ran;
	}

	/*****************************************
	 * 检查购物车中是否存在莫商品(根据商品)
	 *****************************************/
	public static function checkCartGoods($gid,$uid,$cartcode=''){
		try{
			if($uid !=0){
				$rel = cart::objects()->get("goodsid='$gid' AND uid='$uid'");
			}
			if($cartcode != ''){
				$rel = cart::objects()->get("goodsid='$gid' AND cartnumber='$cartcode' AND uid=0");
			}
			if($rel){
				return 'exist';
			}else{
				return 'noexist';
			}
		}catch (Exception $e) {
			return 'noexist';
		}
	}

	/*******************************************
	 * 检查购物中是否存在某商品 （根据购物车id）
	 *******************************************/
	public static function checkCartGd($cart,$uid,$cartcode=''){
		try{
			if($uid != 0){
				$rel = cart::objects()->get("id ='$cart' AND uid='$uid'");
			}
			if($uid =0 && $cartcode !=''){
				$rel = cart::objects()->get("id ='$cart' AND cartnumber='$cartcode' AND uid=0");
			}
			if($rel){
				return 1;
			}else{
				return 2;
			}
		}catch(Exception $e){
			return 2;
		}
	
	}


	/*********************************************************************************
	 * 添加购物车
	 * 首先根据gid查询出商品信息，根据gid查看商品所属的促销活动，再判断是否是登录用户，是，则
	 ********************************************************************************/
	public static function cartAdd($gid,$uid,$cortcode,$count){
		require_once PRO_ROOT . 'include/goods.class.php';
		require_once PRO_ROOT . 'include/base.class.php';
		require_once PRO_ROOT . 'include/cheapFun.class.php';
		$rel = Ware::GetOne($gid);
		if($rel){
			if($uid !=0){    //判断是否登录
				$mid = cheapFun::getUserMid($uid);
				if($mid){
					$price = cheapFun::getGoodsMemberPrice($gid,$mid);
				}else{
					$price = $rel->shopprice;
				}
				$act = cheapFun::getPromotion($gid);    //获取商品活动
				foreach ($act as $item){
					if($item->activity_type==1){
						$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
						if($gcheap){
							$cheap = cheapFun::rebate($price,$count,$gcheap->id);    //获取优惠金额
						}else{
							$cheap = cheapFun::rebate($price,$count,$item->id);    //获取优惠金额
						}
					}

					if($item ->activity_type==2){    //赠品活动
						$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
						if($largess){
							cheapFun::largess($gid,$count,$largess->id,$uid,'');
						}else{
							cheapFun::largess($gid,$count,$item->id,$uid,'');
						}
					}

					if($item->activity_type==3){
						$mark = cheapFun::getGlobalPromotion(3);    //获取全局的积分活动
						$money = $price*$count;    //消费金额
						if($mark){
							$mar = cheapFun::mark($money,$mark->id);    //获取积分
						}else{
							$mar = cheapFun::mark($money,$item->id);    //获取积分
						}
					}

					if($item->activity_type==4){
						$ticket = cheapFun::getGlobalPromotion(4);    //获取全局的优惠券金额
						$money = $price*$count;    //消费金额
						if($ticket){
							$tick = cheapFun::cheap($uid,$money,$ticket->id);
						}else{
							$tick = cheapFun::cheap($uid,$money,$item->id);
						}
					}

					if($item->activity_type==5){
						$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
						$money = $price*$count;    //消费金额
						if($fee){
							$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
						}else{
							$yf = cheapFun::conveyFee($money,$item->id);
						}
						if($yf){
							$yf = 1;
						}else{
							$yf = 0;
						}
					}

				}
				$cart = new cart();
				$cart -> uid = $uid;
				$cart -> goodsid = $rel->id;
				$cart -> goods_sn = $rel->goods_sn;
				$cart -> goodsname = $rel->goodsname;
				if($uid == 0){
					$cart -> mprice = $rel->shopprice;
				}else{
					$cart -> mprice = $price;
				}
				$cart -> shoppirce = $rel->shopprice;
				$cart -> marketprice = $rel->marketprice;
				$cart -> goodscount = $count;
				$cart -> carttime = time();
				$cart -> cheap = $cheap;
				$cart -> mark = $mar;
				$cart -> freight = $yf;
				$cart -> ticket = $tick;
				try{
					$cart -> save();
				}catch(DZGException $e){
					echo "插入购物车失败！";
				}
				$cartid = $cart->id();
				if($cartid){
					return true;
				}
			}else{    //未登录
				$act = cheapFun::getPromotion($gid);    //获取商品活动
				if($cortcode != ''){
					$cartnumber = $cortcode;
				}
				
				foreach ($act as $item){
					if($item->activity_type==1){
						$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
						if($gcheap){
							$cheap = cheapFun::rebate($rel->shopprice,$count,$gcheap->id);    //获取优惠金额
						}else{
							$cheap = cheapFun::rebate($rel->shopprice,$count,$item->id);    //获取优惠金额
						}
					}

					if($item ->activity_type==2){    //赠品活动
						$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
						if($largess){
							cheapFun::largess($gid,$count,$largess->id,0,$cartnumber);
						}else{
							cheapFun::largess($gid,$count,$item->id,0,$cartnumber);
						}
					}

					if($item->activity_type==5){
						$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
						$money = $rel->shopprice*$count;    //消费金额
						if($fee){
							$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
						}else{
							$yf = cheapFun::conveyFee($money,$item->id);
						}
						if($yf){
							$yf = 1;
						}else{
							$yf = 0;
						}
					}
				}
				$cart = new cart();
				$cart -> cartnumber = $cartnumber;
				$cart -> uid = 0;
				$cart -> goodsid = $rel->id;
				$cart -> goods_sn = $rel->goods_sn;
				$cart -> goodsname = $rel->goodsname;
				$cart -> shoppirce = $rel->shopprice;
				$cart -> marketprice = $rel->marketprice;
				$cart -> mprice = $rel->shopprice;
				$cart -> goodscount = $count;
				$cart -> carttime = time();
				$cart -> cheap = $cheap;
				$cart -> freight = $yf;
				$cart -> save();
				$cartid = base::getInsertId();
				if($cartid){
					return true;
				}
			}
		}
		return false;
	}

	/************************************************
	 * 检查购物车  判断用户购物车是否为空
	 ************************************************/
	public static function checkCart($uid,$cartcode){
		try{
			if($uid != 0){
				$rel = cart::objects()->filter("uid='$uid'");
			}elseif($cartcode !=''){
				$rel = cart::objects()->filter("cartnumber='$cartcode'");
			}
			return $rel;
		}catch (Exception $e) {
			return '';
		}
	}

	

	/**
	 *
	 */
	public static function cartInsert($uid,$cartcode,$gid,$gname,$gsn,$count,$price,$marketprice,$attributeid,$attributename){
		require_once PRO_ROOT . 'include/cheapFun.class.php';
		$act = cheapFun::getPromotion($gid);    //获取商品活动
		foreach ($act as $item){
			if($item->activity_type==1){
				$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
				if($gcheap){
					$cheap = cheapFun::rebate($rel->shopprice,$count,$gcheap->id);    //获取优惠金额
				}else{
					$cheap = cheapFun::rebate($rel->shopprice,$count,$item->id);    //获取优惠金额
				}
			}
			
			if($item ->activity_type==2){    //赠品活动
				$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
				if($largess){
					if($uid !=0){
						cheapFun::largess($gid,$count,$largess->id,$uid,'');
					}else{
						cheapFun::largess($gid,$count,$largess->id,0,$cartcode);
					}
				}else{
					if($uid != 0){
						cheapFun::largess($gid,$count,$item->id,$uid,'');
					}else{
						cheapFun::largess($gid,$count,$item->id,0,$cartcode);
					}
				}
			}
	

			if($item->activity_type==5){
				$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
				$money = $rel->shopprice*1;    //消费金额
				if($fee){
					$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
				}else{
					$yf = cheapFun::conveyFee($money,$item->id);
				}
				if($yf){
					$yf = 1;
				}else{
					$yf = 0;
				}
			}
		}
		$cart = new cart();
		$cart -> cartnumber = $cartcode;
		$cart -> uid = $uid;
		$cart -> goodsid = $gid;
		$cart -> goods_sn = $gsn;
		$cart -> goodsname = $gname;
		$cart -> shoppirce = $price;
		$cart -> marketprice = $marketprice;
		$cart -> goodscount = $count;
		$cart -> attributeid = $attributeid;
		$cart -> attributename = $attributename;
		$cart -> carttime = time();
		$cart -> cheap = $cheap;
		$cart -> freight = $yf;
		$car = $cart -> save();
		if($car){
			return true;
		}
	}

	/**
	 * 获取用户购物数与总额
	 * @param int $uid 用户id
	 * @param string $cartnumber 购物车编号
	 */
	public static function GetCountMoney($uid=''){
		try{
			$where = '';
			if($uid != ''){
				$where = "uid ='$uid' AND largess =0";
				$rel = cart::objects()->filter($where);
			}else{
				if(isset($_COOKIE['cart'])){
					$cartnumber = $_COOKIE['cart'];
					$where = "cartnumber = '$cartnumber' AND largess=0";
					$rel = cart::objects()->filter($where);
				}
			}
			if($rel){
				$count = count($rel);
				$money = 0;
				foreach ($rel as $item){
					$money =$money + $item->shoppirce * $item->goodscount - $tiem->cheap;
				}
				$arry = array('count'=>$count,'money'=>$money);
				return $arry;
			}
		}catch (Exception $e) {
			return false;
		}
	}

	/***********************************************
	 * 我的购物车
	 ***********************************************/
	public static function getCart($uid,$cartcode){
		$where = '';
		if($uid != 0){
			$where = "uid = '$uid'";
		}elseif($cartcode != ''){
			$where = "cartnumber = '$cartcode' AND uid=0";
		}else{
			return '';
		}
		try{
			$rel = cart::objects()->filter($where);
			if($rel){
				return $rel;
			}
		}catch (Exception $e) {
			return '';
		}
	}

	/**
	 * 修改购物车的数量
	 */
/*	public static function updateCount($cart,$count,$gid){
		require_once PRO_ROOT . 'include/goods.class.php';
		require_once PRO_ROOT . 'include/cheapFun.class.php';
		$rel = Ware::GetOne($gid);
		cheapFun::uplargess($gid);    //清空购物车中此商品的赠品
		if($rel->leavingcount>=$count){
			if($rel){
				//auth::authUser();
				$login = auth::isUserLogin();    //判断用户是否登录
				if($login){    //判断是否登录
					$uid = auth::getUserId();
					$act = cheapFun::getPromotion($gid);    //获取商品活动
					$mid = cheapFun::getUserMid($uid);
					if($mid){
						$price = cheapFun::getGoodsMemberPrice($gid,$mid);
					}else{
						$price = $rel->shopprice;
					}

					foreach ($act as $item){
						if($item->activity_type==1){
							$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
							if($gcheap){
								$cheap = cheapFun::rebate($price,$count,$gcheap->id);    //获取优惠金额
							}else{
								$cheap = cheapFun::rebate($price,$count,$item->id);    //获取优惠金额
							}
						}

						if($item ->activity_type==2){    //赠品活动
							$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
							if($largess){
								cheapFun::largess($gid,$count,$largess->id,$uid,'');
							}else{
								cheapFun::largess($gid,$count,$item->id,$uid,'');
							}
						}

						if($item->activity_type==3){
							$mark = cheapFun::getGlobalPromotion(3);    //获取全局的积分活动
							$money = $price*$count;    //消费金额
							if($mark){
								$mar = cheapFun::mark($money,$mark->id);    //获取积分
							}else{
								$mar = cheapFun::mark($money,$item->id);    //获取积分
							}
						}

						if($item->activity_type==4){
							$ticket = cheapFun::getGlobalPromotion(4);    //获取全局的优惠券金额
							$money = $price*$count;    //消费金额
							if($ticket){
								$tick = cheapFun::cheap($uid,$money,$ticket->id);
							}else{
								$tick = cheapFun::cheap($uid,$money,$item->id);
							}
						}

						if($item->activity_type==5){
							$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
							$money = $price*1;    //消费金额
							if($fee){
								$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
							}else{
								$yf = cheapFun::conveyFee($money,$item->id);
							}
							if($yf){
								$yf = 1;
							}else{
								$yf = 0;
							}
						}
					}
		
					$carts = new cart();
					$carts ->id = $cart;
					$carts ->goodscount = $count;
					$carts ->mark = $mar;
					$carts ->cheap = $cheap;
					$carts ->freight = $yf;
					$carts ->ticket = $tick;
					$rel = $carts ->save();
					if($rel){
						return 1;
					}
				}else{    //未登录
					$act = cheapFun::getPromotion($gid);    //获取商品活动
					foreach ($act as $item){
						if($item->activity_type==1){
							$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
							if($gcheap){
								$cheap = cheapFun::rebate($rel->shopprice,$count,$gcheap->id);    //获取优惠金额
							}else{
								$cheap = cheapFun::rebate($rel->shopprice,$count,$item->id);    //获取优惠金额
							}
						}

						if($item ->activity_type==2){    //赠品活动
							$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
							if($largess){
								cheapFun::largess($gid,1,$largess->id,0,$_COOKIE['cart']);
							}else{
								cheapFun::largess($gid,1,$item->id,0,$_COOKIE['cart']);
							}
						}

						if($item->activity_type==5){
							$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
							$money = $rel->shopprice*1;    //消费金额
							if($fee){
								$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
							}else{
								$yf = cheapFun::conveyFee($money,$item->id);
							}
							if($yf){
								$yf = 1;
							}else{
								$yf = 0;
							}
						}
					}
					$carts = new cart();
					$carts ->id = $cart;
					$carts ->goodscount = $count;
					$carts ->cheap = $cheap;
					$carts ->freight = $yf;
					$ch = $carts ->save();
					if($ch){
						return 1;
					}
				}
			}
		}else{
			return 2;
		}
	}
*/




	/**********************************************************
	 * 修改购物车的数量
	 **********************************************************/
	public static function changeCartCount($cart,$count,$uid,$cartcode,$gid){
		require_once PRO_ROOT . 'include/goods.class.php';
		require_once PRO_ROOT . 'include/cheapFun.class.php';
		$rel = Ware::GetOne($gid);
		cheapFun::uplargess($gid,$uid,$cartcode);    //清空购物车中此商品的赠品
		if($rel->leavingcount>=$count){
			if($rel){
				if($uid != 0){    //判断是否登录
					$act = cheapFun::getPromotion($gid);    //获取商品活动
					$mid = cheapFun::getUserMid($uid);
					if($mid){
						$price = cheapFun::getGoodsMemberPrice($gid,$mid);
					}else{
						$price = $rel->shopprice;
					}
					foreach ($act as $item){
						if($item->activity_type==1){
							$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
							if($gcheap){
								$cheap = cheapFun::rebate($price,$count,$gcheap->id);    //获取优惠金额
							}else{
								$cheap = cheapFun::rebate($price,$count,$item->id);    //获取优惠金额
							}
						}
						
						$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
						if($largess){
							cheapFun::largess($gid,$count,$largess->id,$uid,'');
						}else{
							if($item ->activity_type==2){    //赠品活动
								cheapFun::largess($gid,$count,$item->id,$uid,'');
							}
						}
						

						if($item->activity_type==3){
							$mark = cheapFun::getGlobalPromotion(3);    //获取全局的积分活动
							$money = $price*$count;    //消费金额
							if($mark){
								$mar = cheapFun::mark($money,$mark->id);    //获取积分
							}else{
								$mar = cheapFun::mark($money,$item->id);    //获取积分
							}
						}

						if($item->activity_type==4){
							$ticket = cheapFun::getGlobalPromotion(4);    //获取全局的优惠券金额
							$money = $price*$count;    //消费金额
							if($ticket){
								$tick = cheapFun::cheap($uid,$money,$ticket->id);
							}else{
								$tick = cheapFun::cheap($uid,$money,$item->id);
							}
						}

						if($item->activity_type==5){
							$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
							$money = $price*1;    //消费金额
							if($fee){
								$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
							}else{
								$yf = cheapFun::conveyFee($money,$item->id);
							}
							if($yf){
								$yf = 1;
							}else{
								$yf = 0;
							}
						}
					}
		
					$carts = new cart();
					$carts ->id = $cart;
					$carts ->goodscount = $count;
					$carts ->mark = $mar;
					$carts ->cheap = $cheap;
					$carts ->freight = $yf;
					$carts ->ticket = $tick;

					$rel = $carts ->save();
					if($rel){
						return 1;
					}
				}else{    //未登录
					$act = cheapFun::getPromotion($gid);    //获取商品活动
					foreach ($act as $item){
						if($item->activity_type==1){
							$gcheap = cheapFun::getGlobalPromotion(1);    //获取全局的折扣活动
							if($gcheap){
								$cheap = cheapFun::rebate($rel->shopprice,$count,$gcheap->id);    //获取优惠金额
							}else{
								$cheap = cheapFun::rebate($rel->shopprice,$count,$item->id);    //获取优惠金额
							}
						}

						if($item ->activity_type==2){    //赠品活动
							$largess = cheapFun::getGlobalPromotion(2);    //获取全局的赠品活动
							if($largess){
								cheapFun::largess($gid,1,$largess->id,0,$cartcode);
							}else{
								cheapFun::largess($gid,1,$item->id,0,$cartcode);
							}
						}

						if($item->activity_type==5){
							$fee = cheapFun::getGlobalPromotion(5);    //获取全局的免运费
							$money = $rel->shopprice*1;    //消费金额
							if($fee){
								$yf = cheapFun::conveyFee($money,$fee->id);    //获取是否免运费
							}else{
								$yf = cheapFun::conveyFee($money,$item->id);
							}
							if($yf){
								$yf = 1;
							}else{
								$yf = 0;
							}
						}
					}
					$carts = new cart();
					$carts ->id = $cart;
					$carts ->goodscount = $count;
					$carts ->cheap = $cheap;
					$carts ->freight = $yf;
					$ch = $carts ->save();
					if($ch){
						return 1;
					}
				}
			}
		}else{
			return 2;
		}
	}


	/*****************************************************
	 * 检查用户购物车中的商品是否是当前用户的
	 *****************************************************/
	public static function checkUserCart($cart,$uid,$cartcode){
		try{
			if($uid !=0){
				$rel = cart::objects()->get("id='$cart' AND uid= '$uid'");
			}elseif($cartcode !=''){
				$rel = cart::objects()->get("id='$cart' AND cartnumber='$cartcode' AND uid =0");
			}
			if($rel){
				return true;
			}else{
				return false;
			}
		}catch (Exception $e) {
			return false;
		}
	}

	/********************************************
	 * 删除购物车
	 ********************************************/
	public static function delCart($cart){
		global $db;
		$ginfo = cart::objects()->get("id='$cart'")	;    //获取此购物车的商品
		$gid = $ginfo ->goodsid;
		$uid = $ginfo ->uid;
		$cartnumber = $ginfo ->cartnumber;
		$sql = "DELETE FROM cart WHERE id ='$cart'";
		$rel = $db ->exec($sql);
		if($rel){
			$sq = "DELETE FROM cart	WHERE host = '$gid' AND uid ='$uid' AND cartnumber='$cartnumber'";
			$result = $db ->exec($sq);
			return true;
		}else{
			return false;
		}
	}

	/*********************************************
	 * 清空购物车
	 *********************************************/
	public static function clearCart($uid,$cartnum=''){
		global $db;
		if($uid != 0){
			$sql = "DELETE FROM cart WHERE uid ='$uid'";
		}elseif($cartnum != ''){
			$sql = "DELETE FROM cart WHERE cartnumber = '$cartnum' AND uid =0";
		}
		try{
			$rel = $db ->exec($sql);
			if($rel){
				return true;
			}
		}catch (Exception $e){
			return false;
		}
	}

	/**
	 * 获取购物车信息
	 */
	public static function getCartInfo($uid,$cartcode){
		try{
			if($uid !=0){
				$rel = cart::objects()->filter("uid='$uid'","carttime");
			}elseif($cartcode !=''){
				$rel = cart::objects()->filter("cartnumber = '$cartcode'","carttime");
			}else{
				return '';
			}
			if($rel){
				return $rel;
			}
		}catch (Exception $e){
			return false;
		}
	}




	
}
?>